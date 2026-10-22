"""
Unit & Integration Tests for Phase 4: Greedy Case Auto-Assignment
=================================================================
Tests all 14 scenarios specified in Phase 4 requirements:
1. A citizen submits a new complaint.
2. The complaint appears in the existing Admin panel.
3. The administrator runs Greedy Auto-Assign recommendation.
4. The algorithm selects the eligible officer with the lowest active workload.
5. The recommendation and explanation appear correctly.
6. The administrator confirms the assignment.
7. The database stores the correct officer ID and name against the complaint.
8. The complaint appears in that officer's dashboard.
9. The officer can use the existing workflow to update the complaint status.
10. The Admin panel and existing reports reflect the updated data.
11. No assignment occurs when no eligible officer exists.
12. Cancelling the recommendation leaves the database unchanged.
13. Repeated confirmation does not create duplicate assignments.
14. Inactive or ineligible officers are never recommended.
"""

import unittest
import json
import sqlite3
import os

import app as ccms_app
import db
import static_data
import phase4


class TestPhase4GreedyAlgorithm(unittest.TestCase):
    """Pure algorithmic unit tests for Phase 4 Greedy Officer Recommendation."""

    def setUp(self):
        self.sample_officers = [
            {"officer_id": "OFF-101", "name": "Officer Ravi", "department": "Police & Law Enforcement", "status": "Active", "active_cases": 5},
            {"officer_id": "OFF-102", "name": "Officer Amit", "department": "Police & Law Enforcement", "status": "Active", "active_cases": 2},
            {"officer_id": "OFF-103", "name": "Officer Priya", "department": "Police & Law Enforcement", "status": "Active", "active_cases": 4},
            {"officer_id": "OFF-104", "name": "Officer Inactive", "department": "Police & Law Enforcement", "status": "Inactive", "active_cases": 0},
            {"officer_id": "OFF-105", "name": "Officer Suresh", "department": "Healthcare & Supplies", "status": "Active", "active_cases": 1},
        ]

        self.sample_complaints = [
            {"complaint_id": "C-1", "assigned_officer_id": "OFF-101", "complaint_status": "Investigation Active"},
            {"complaint_id": "C-2", "assigned_officer_id": "OFF-101", "complaint_status": "Under Review"},
            {"complaint_id": "C-3", "assigned_officer_id": "OFF-101", "complaint_status": "Resolved"},  # Not active
            {"complaint_id": "C-4", "assigned_officer_id": "OFF-102", "complaint_status": "Assigned"},
            {"complaint_id": "C-5", "assigned_officer_id": "OFF-103", "complaint_status": "Under Review"},
            {"complaint_id": "C-6", "assigned_officer_id": "OFF-103", "complaint_status": "Closed"},    # Not active
        ]

    def test_calculate_officer_workload_counts_only_active(self):
        """Active workload must count only active statuses and exclude Resolved/Closed."""
        workload_101 = phase4.calculate_officer_workload("OFF-101", self.sample_complaints)
        self.assertEqual(workload_101, 2)  # C-1 and C-2, C-3 is resolved

        workload_102 = phase4.calculate_officer_workload("OFF-102", self.sample_complaints)
        self.assertEqual(workload_102, 1)  # C-4

        workload_103 = phase4.calculate_officer_workload("OFF-103", self.sample_complaints)
        self.assertEqual(workload_103, 1)  # C-5, C-6 is closed

        workload_none = phase4.calculate_officer_workload("OFF-999", self.sample_complaints)
        self.assertEqual(workload_none, 0)

    def test_get_eligible_officers_excludes_inactive_and_mismatched(self):
        """Inactive officers and different departments must be excluded."""
        comp = {"complaint_id": "TEST-1", "sector": "Police & Law Enforcement"}
        eligible, note = phase4.get_eligible_officers(comp, self.sample_officers, strict_department=True)

        eligible_ids = [o["officer_id"] for o in eligible]
        # Must include active police officers
        self.assertIn("OFF-101", eligible_ids)
        self.assertIn("OFF-102", eligible_ids)
        self.assertIn("OFF-103", eligible_ids)

        # Must EXCLUDE inactive officer (Scenario 14)
        self.assertNotIn("OFF-104", eligible_ids)
        # Must EXCLUDE healthcare officer when departmental matching is strict
        self.assertNotIn("OFF-105", eligible_ids)

    def test_greedy_selects_lowest_workload_officer(self):
        """Greedy choice property: Recommend officer with lowest active workload (Scenario 4)."""
        comp = {"complaint_id": "TEST-1", "sector": "Police & Law Enforcement"}
        eligible, _ = phase4.get_eligible_officers(comp, self.sample_officers)
        
        # OFF-101 has workload 2, OFF-102 has workload 1, OFF-103 has workload 1
        rec = phase4.recommend_officer(comp, eligible, self.sample_complaints)

        self.assertEqual(rec["status"], "SUCCESS")
        # Both OFF-102 and OFF-103 have workload 1; tie-breaker chooses OFF-102 by ID
        self.assertEqual(rec["recommended_officer"]["officer_id"], "OFF-102")
        self.assertEqual(rec["workload"], 1)
        self.assertIn("Greedy choice", rec["reason"])

    def test_tie_breaking_consistency(self):
        """When multiple officers have identical minimum workloads, tie is broken deterministically."""
        tied_officers = [
            {"officer_id": "OFF-Z99", "name": "Officer Zara", "department": "Revenue", "status": "Active", "active_cases": 1},
            {"officer_id": "OFF-A01", "name": "Officer Amar", "department": "Revenue", "status": "Active", "active_cases": 1},
            {"officer_id": "OFF-M50", "name": "Officer Manoj", "department": "Revenue", "status": "Active", "active_cases": 1},
        ]
        comp = {"complaint_id": "TEST-TIE", "sector": "Revenue"}
        
        rec = phase4.recommend_officer(comp, tied_officers, complaints_data=[])
        self.assertEqual(rec["status"], "SUCCESS")
        # OFF-A01 should be chosen because 'OFF-A01' < 'OFF-M50' < 'OFF-Z99'
        self.assertEqual(rec["recommended_officer"]["officer_id"], "OFF-A01")
        self.assertIn("Tie broken deterministically", rec["reason"])

    def test_empty_eligible_officers_safe_handling(self):
        """When no eligible officer exists, return NO_ELIGIBLE_OFFICERS safely (Scenario 11)."""
        comp = {"complaint_id": "TEST-EMPTY", "sector": "Nonexistent Dept"}
        rec = phase4.recommend_officer(comp, eligible_officers=[], complaints_data=[])
        
        self.assertEqual(rec["status"], "NO_ELIGIBLE_OFFICERS")
        self.assertIsNone(rec["recommended_officer"])
        self.assertEqual(rec["eligible_count"], 0)
        self.assertIn("No active and eligible officers", rec["reason"])

    def test_batch_planning_sequential_balancing(self):
        """Batch greedy planner updates virtual workloads sequentially to prevent skew."""
        pool = [
            {"officer_id": "OFF-01", "name": "Officer A", "department": "PWD", "status": "Active", "active_cases": 0},
            {"officer_id": "OFF-02", "name": "Officer B", "department": "PWD", "status": "Active", "active_cases": 0},
        ]
        unassigned = [
            {"complaint_id": "CASE-1", "sector": "PWD", "complaint_title": "Case 1"},
            {"complaint_id": "CASE-2", "sector": "PWD", "complaint_title": "Case 2"},
        ]

        plan = phase4.plan_greedy_batch_assignments(unassigned, pool, active_complaints=[])
        self.assertEqual(len(plan), 2)
        # First case assigned to OFF-01 (load 0 -> 1)
        self.assertEqual(plan[0]["recommendation"]["recommended_officer"]["officer_id"], "OFF-01")
        # Second case assigned to OFF-02 because OFF-01 is now virtually loaded with 1
        self.assertEqual(plan[1]["recommendation"]["recommended_officer"]["officer_id"], "OFF-02")


class TestPhase4IntegrationWorkflow(unittest.TestCase):
    """End-to-end integration tests using Flask test client and live CCMS SQLite database."""

    def setUp(self):
        self.app = ccms_app.app
        self.app.config["TESTING"] = True
        self.client = self.app.test_client()

        # Ensure database is initialized with static_data
        db.init_db(force_reseed=False)

    def test_recommendation_api_and_two_phase_confirmation(self):
        """Tests Scenarios 1-10: Intake -> Greedy Recommendation -> Confirmation -> Reflection."""
        with self.client.session_transaction() as sess:
            sess["user_id"] = 1
            sess["full_name"] = "Super Admin"
            sess["role"] = "admin"

        # 1. Citizen submits a new complaint into Healthcare & Supplies
        new_cid = "CCMS-TEST-4001"
        db.execute_db(
            """INSERT OR REPLACE INTO complaints 
               (complaint_id, user_id, complaint_title, misconduct_category, sector, incident_date, location, description, severity, complaint_status)
               VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, 'Pending')""",
            (new_cid, 2, "Test Hospital Medicine Diversion", "Medical Supply Embezzlement", "Healthcare & Supplies",
             "2026-09-01", "District Hospital", "Test description for Phase 4 audit", "High")
        )

        # 2. Complaint appears in unassigned complaints list
        resp = self.client.get("/admin/assignment")
        self.assertEqual(resp.status_code, 200)
        self.assertIn(new_cid.encode(), resp.data)

        # 3 & 4 & 5. Administrator runs Greedy Auto-Assign recommendation
        rec_resp = self.client.get(f"/admin/assignment/recommend?complaint_id={new_cid}")
        self.assertEqual(rec_resp.status_code, 200)
        rec_data = json.loads(rec_resp.data)
        self.assertEqual(rec_data["status"], "SUCCESS")
        
        # Verify recommended officer is eligible and holds lowest workload
        recommended = rec_data["recommended_officer"]
        self.assertIsNotNone(recommended)
        self.assertEqual(recommended["department"], "Healthcare & Supplies")
        self.assertIn("Greedy choice", rec_data["reason"])

        # 12. Cancelling recommendation leaves database unchanged (assigned_officer remains None)
        complaint_pre = db.query_db("SELECT * FROM complaints WHERE complaint_id = %s", (new_cid,), one=True)
        self.assertIsNone(complaint_pre.get("assigned_officer"))

        # 6 & 7. Administrator confirms the assignment
        confirm_resp = self.client.post("/admin/assignment/confirm", data={
            "complaint_id": new_cid,
            "officer_id": recommended["officer_id"]
        }, headers={"X-Requested-With": "XMLHttpRequest"})
        
        self.assertEqual(confirm_resp.status_code, 200)
        conf_data = json.loads(confirm_resp.data)
        self.assertEqual(conf_data["status"], "SUCCESS")

        # 7. Database stores the correct officer ID and name against the complaint
        updated_comp = db.query_db("SELECT * FROM complaints WHERE complaint_id = %s", (new_cid,), one=True)
        self.assertEqual(updated_comp["assigned_officer_id"], recommended["officer_id"])
        self.assertEqual(updated_comp["assigned_officer"], recommended["name"])
        self.assertEqual(updated_comp["complaint_status"], "Under Review")

        # 13. Repeated confirmation does not create duplicate assignments
        repeat_resp = self.client.post("/admin/assignment/confirm", data={
            "complaint_id": new_cid,
            "officer_id": recommended["officer_id"]
        }, headers={"X-Requested-With": "XMLHttpRequest"})
        self.assertEqual(repeat_resp.status_code, 409)  # Conflict / ALREADY_ASSIGNED

        # 8. Complaint appears in that officer's dashboard
        with self.client.session_transaction() as sess:
            sess["user_id"] = recommended["officer_id"]
            sess["full_name"] = recommended["name"]
            sess["role"] = "officer"
            sess["department"] = recommended["department"]

        officer_dash_resp = self.client.get("/officer/dashboard")
        self.assertEqual(officer_dash_resp.status_code, 200)
        self.assertIn(new_cid.encode(), officer_dash_resp.data)

        # 9. Officer can use the existing workflow to update the complaint status
        update_resp = self.client.post(f"/officer/investigation/{new_cid}", data={
            "status": "Investigation Active",
            "notes": "Preliminary subpoena issued to pharmacy records."
        }, follow_redirects=True)
        self.assertEqual(update_resp.status_code, 200)

        refreshed_comp = db.query_db("SELECT * FROM complaints WHERE complaint_id = %s", (new_cid,), one=True)
        self.assertEqual(refreshed_comp["complaint_status"], "Investigation Active")

        # 10. Admin panel complaints and reports reflect the updated data
        with self.client.session_transaction() as sess:
            sess["user_id"] = 1
            sess["full_name"] = "Super Admin"
            sess["role"] = "admin"

        reports_resp = self.client.get("/admin/reports")
        self.assertEqual(reports_resp.status_code, 200)
        self.assertIn(new_cid.encode(), reports_resp.data)
        self.assertIn(recommended["name"].encode(), reports_resp.data)

        # Cleanup test record
        db.execute_db("DELETE FROM complaints WHERE complaint_id = %s", (new_cid,))

    def test_citizen_dashboard_displays_only_own_complaints(self):
        """Verify that a new citizen only sees complaints they created, not complaints by other users or user_id=1."""
        # Create a new citizen with unique ID 8888
        new_citizen_id = 8888
        db.execute_db(
            "INSERT OR REPLACE INTO users (id, full_name, email, mobile_number, password, role) VALUES (%s, %s, %s, %s, %s, 'citizen')",
            (new_citizen_id, "Nishant Test", "nishant@test.com", "9998887770", "hash123")
        )

        with self.client.session_transaction() as sess:
            sess["user_id"] = new_citizen_id
            sess["full_name"] = "Nishant Test"
            sess["role"] = "citizen"

        # Check dashboard for new citizen who hasn't filed any complaint yet
        dash_resp = self.client.get("/citizen/dashboard")
        self.assertEqual(dash_resp.status_code, 200)
        # Must show 0 filed complaints and empty state message
        self.assertIn(b"Total Filed", dash_resp.data)
        self.assertIn(b"No Complaints Logged Yet", dash_resp.data)
        # Must NOT show admin/other complaints like CCMS-2026-6795 or CCMS-2026-4366
        self.assertNotIn(b"CCMS-2026-6795", dash_resp.data)
        self.assertNotIn(b"CCMS-2026-4366", dash_resp.data)

        # Now this citizen files one complaint
        citizen_cid = "CCMS-NISHANT-001"
        db.execute_db(
            """INSERT INTO complaints 
               (complaint_id, user_id, complaint_title, misconduct_category, sector, incident_date, location, description, severity, complaint_status)
               VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, 'Pending')""",
            (citizen_cid, new_citizen_id, "Nishant Personal Complaint", "Bribery", "Police & Law Enforcement", "2026-10-22", "Local Station", "Personal complaint", "Low")
        )

        dash_after = self.client.get("/citizen/dashboard")
        self.assertEqual(dash_after.status_code, 200)
        self.assertIn(citizen_cid.encode(), dash_after.data)
        self.assertNotIn(b"CCMS-2026-6795", dash_after.data)
        self.assertNotIn(b"CCMS-2026-4366", dash_after.data)

        # Cleanup
        db.execute_db("DELETE FROM complaints WHERE complaint_id = %s", (citizen_cid,))
        db.execute_db("DELETE FROM users WHERE id = %s", (new_citizen_id,))


if __name__ == "__main__":
    unittest.main()
