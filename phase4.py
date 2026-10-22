"""
CCMS - Phase 4: Algorithmic Problem Solving & Data Optimization
==============================================================
Greedy Algorithm for Complaint-to-Officer Workload Balancing.

Core Algorithm:
---------------
A Greedy Algorithm makes the locally optimal choice at each stage with the
goal of finding a global optimum. In CCMS case assignment:
- Goal: Maintain equitable workload balance across vigilance inspectors while
  strictly respecting departmental jurisdiction and officer availability.
- Greedy Selection Rule: At each assignment step, pick the eligible officer
  who currently holds the minimum active workload (min active cases).
- Tie-breaking Rule: When workloads are identical, break ties deterministically
  using the officer's unique identifier (`officer_id`) in ascending order.
- Time Complexity: O(M log M) or O(M) where M is the number of eligible officers.
"""

from typing import Dict, List, Optional, Tuple, Any

# Complaints statuses representing active, ongoing investigative work
ACTIVE_STATUSES = {"Pending", "Under Review", "Investigation Active", "Assigned"}
# Complaints statuses representing finalized cases (no active workload)
RESOLVED_STATUSES = {"Resolved", "Closed", "Rejected"}


def calculate_officer_workload(officer_id: str, complaints: List[Dict[str, Any]]) -> int:
    """
    Calculate the current active workload for an officer from complaint records.
    Only counts complaints assigned to this officer that are in an active status.

    Args:
        officer_id: Unique identifier of the officer (e.g. 'OFF-4402')
        complaints: List of complaint dictionaries from the CCMS dataset

    Returns:
        int: Number of active assigned complaints
    """
    if not officer_id or not complaints:
        return 0

    count = 0
    for c in complaints:
        assigned_id = str(c.get("assigned_officer_id") or "").strip()
        assigned_name = str(c.get("assigned_officer") or "").strip()
        status = str(c.get("complaint_status") or "").strip()

        # Check match by ID or full name
        if (assigned_id == officer_id or (assigned_id == "" and assigned_name == officer_id)):
            if status in ACTIVE_STATUSES and status not in RESOLVED_STATUSES:
                count += 1

    return count


def get_eligible_officers(
    complaint: Dict[str, Any],
    officers: List[Dict[str, Any]],
    strict_department: bool = True
) -> Tuple[List[Dict[str, Any]], str]:
    """
    Filter officers based on availability status and departmental jurisdiction.

    Eligibility Rules:
    1. Status must be 'Active' (exclude 'Inactive', 'Suspended', 'On Leave').
    2. Department must match complaint's sector.
    3. If strict_department is False or if no officer exists in the sector,
       active officers across the Central Vigilance network may be considered as fallback.

    Args:
        complaint: Complaint dictionary containing 'sector' or 'department'
        officers: List of officer dictionaries from static_data or database
        strict_department: If True, only officers in the matching department are eligible

    Returns:
        Tuple of (eligible_officers_list, eligibility_note)
    """
    target_sector = (complaint.get("sector") or complaint.get("department") or "").strip()

    # Step 1: Filter only Active officers
    active_officers = [
        o for o in officers
        if str(o.get("status") or "").strip().lower() == "active"
    ]

    if not active_officers:
        return [], "No active vigilance officers found in system roster."

    # Step 2: Match departmental jurisdiction
    dept_matches = [
        o for o in active_officers
        if str(o.get("department") or "").strip().lower() == target_sector.lower()
    ]

    if dept_matches:
        return dept_matches, f"Matched {len(dept_matches)} active officer(s) in department: '{target_sector}'."

    # If strict matching was requested and no departmental match found
    if strict_department:
        # Fallback to HQ officers or all active officers if department has no dedicated unit
        hq_matches = [
            o for o in active_officers
            if "hq" in str(o.get("department") or "").lower() or "directorate" in str(o.get("department") or "").lower()
        ]
        if hq_matches:
            return hq_matches, f"No dedicated officers in '{target_sector}'. Allocated {len(hq_matches)} Central Vigilance HQ officer(s)."
        
        # When no specific department match exists, fallback gracefully to all active officers
        return active_officers, f"No dedicated officer in '{target_sector}'. Expanded candidate pool to all {len(active_officers)} active officer(s)."

    return active_officers, f"Expanded candidate pool to all {len(active_officers)} active officer(s)."


def recommend_officer(
    complaint: Dict[str, Any],
    eligible_officers: List[Dict[str, Any]],
    complaints_data: Optional[List[Dict[str, Any]]] = None,
    tie_breaker_key: str = "officer_id"
) -> Dict[str, Any]:
    """
    Phase 4 Greedy Algorithm:
    Recommends the single most suitable eligible officer with the lowest current workload.
    
    Greedy Choice:
      min(workload) among all eligible officers.
    Tie-breaking:
      Deterministic sorting by tie_breaker_key (default 'officer_id').

    Args:
        complaint: Complaint record to be assigned
        eligible_officers: List of active, departmental-eligible officer records
        complaints_data: Full list of complaints used to calculate live workloads dynamically.
                         If None, uses 'active_cases' field from the officer record.
        tie_breaker_key: Key used to break ties (default: 'officer_id')

    Returns:
        dict: Recommendation payload containing:
            - status: 'SUCCESS' or 'NO_ELIGIBLE_OFFICERS'
            - recommended_officer: dict of selected officer
            - workload: int (active caseload)
            - eligible_count: int
            - evaluated_candidates: list of candidate summaries
            - reason: human-readable explanation of the greedy decision
            - complaint_id: str
            - complaint_title: str
            - department: str
    """
    complaint_id = complaint.get("complaint_id") or complaint.get("id") or "UNKNOWN"
    complaint_title = complaint.get("complaint_title") or complaint.get("title") or "Untitled Case"
    sector = complaint.get("sector") or complaint.get("department") or "General Vigilance"

    if not eligible_officers:
        return {
            "status": "NO_ELIGIBLE_OFFICERS",
            "recommended_officer": None,
            "workload": 0,
            "eligible_count": 0,
            "evaluated_candidates": [],
            "reason": f"No active and eligible officers are currently available for department '{sector}'.",
            "complaint_id": complaint_id,
            "complaint_title": complaint_title,
            "department": sector
        }

    # Calculate workload for each eligible candidate
    candidate_pool = []
    for off in eligible_officers:
        off_id = str(off.get("officer_id") or off.get("id") or "").strip()
        name = str(off.get("name") or "").strip()
        dept = str(off.get("department") or "").strip()
        rank = str(off.get("rank") or "Inspector").strip()

        if complaints_data is not None:
            workload = calculate_officer_workload(off_id, complaints_data)
        else:
            workload = int(off.get("active_cases", 0))

        candidate_pool.append({
            "officer_id": off_id,
            "name": name,
            "rank": rank,
            "department": dept,
            "workload": workload,
            "badge_id": off.get("badge_id", f"ACB-{off_id}"),
            "status": off.get("status", "Active"),
            "email": off.get("email", "")
        })

    # GREEDY SELECTION:
    # Primary key: workload (ascending - lowest active caseload first)
    # Secondary key (tie-breaker): tie_breaker_key (e.g. officer_id ascending)
    candidate_pool.sort(
        key=lambda x: (x["workload"], str(x.get(tie_breaker_key, x["officer_id"])).upper())
    )

    chosen = candidate_pool[0]
    min_workload = chosen["workload"]

    # Check how many officers tied with the minimum workload
    tied_officers = [c for c in candidate_pool if c["workload"] == min_workload]
    if len(tied_officers) > 1:
        reason = (
            f"Greedy choice: Recommended '{chosen['name']}' ({chosen['officer_id']}) because this officer "
            f"has the lowest active workload ({min_workload} active case{'s' if min_workload != 1 else ''}) "
            f"among {len(candidate_pool)} eligible officer(s). Tie broken deterministically by "
            f"officer identifier '{chosen['officer_id']}'."
        )
    else:
        reason = (
            f"Greedy choice: Recommended '{chosen['name']}' ({chosen['officer_id']}) because this officer "
            f"holds the strictly lowest active workload ({min_workload} active case{'s' if min_workload != 1 else ''}) "
            f"among {len(candidate_pool)} eligible officer(s) in '{chosen['department']}'."
        )

    return {
        "status": "SUCCESS",
        "recommended_officer": chosen,
        "workload": min_workload,
        "eligible_count": len(candidate_pool),
        "evaluated_candidates": candidate_pool,
        "reason": reason,
        "complaint_id": complaint_id,
        "complaint_title": complaint_title,
        "department": sector
    }


def plan_greedy_batch_assignments(
    unassigned_complaints: List[Dict[str, Any]],
    officers: List[Dict[str, Any]],
    active_complaints: List[Dict[str, Any]]
) -> List[Dict[str, Any]]:
    """
    Greedy Batch Planner:
    Precomputes optimal greedy assignments for a batch of unassigned complaints
    while tracking simulated workloads sequentially so that no officer is disproportionately loaded.

    Args:
        unassigned_complaints: List of complaints needing assignment
        officers: Available officer roster
        active_complaints: Currently active complaints in the system

    Returns:
        List of assignment plan items with recommendation details for each complaint.
    """
    # Track virtual workloads during batch planning
    virtual_workloads = {}
    for off in officers:
        off_id = str(off.get("officer_id") or off.get("id") or "").strip()
        virtual_workloads[off_id] = calculate_officer_workload(off_id, active_complaints)

    planned_assignments = []

    for comp in unassigned_complaints:
        eligible, _ = get_eligible_officers(comp, officers, strict_department=True)
        if not eligible:
            planned_assignments.append({
                "complaint": comp,
                "recommendation": None,
                "status": "UNASSIGNABLE",
                "reason": "No active eligible officer available."
            })
            continue

        # Sort eligible officers by their current virtual workload
        candidates = []
        for o in eligible:
            oid = str(o.get("officer_id") or o.get("id") or "").strip()
            candidates.append({
                "officer_id": oid,
                "name": o.get("name"),
                "rank": o.get("rank"),
                "department": o.get("department"),
                "workload": virtual_workloads.get(oid, 0),
                "badge_id": o.get("badge_id")
            })

        candidates.sort(key=lambda x: (x["workload"], x["officer_id"]))
        best = candidates[0]

        # Update virtual workload for the chosen officer so next complaint sees updated load
        virtual_workloads[best["officer_id"]] += 1

        rec = {
            "status": "SUCCESS",
            "recommended_officer": best,
            "workload": best["workload"],
            "eligible_count": len(candidates),
            "evaluated_candidates": candidates,
            "reason": (
                f"Greedy optimization assigned '{best['name']}' ({best['officer_id']}) with "
                f"current workload of {best['workload']} active cases."
            ),
            "complaint_id": comp.get("complaint_id"),
            "complaint_title": comp.get("complaint_title"),
            "department": comp.get("sector")
        }

        planned_assignments.append({
            "complaint": comp,
            "recommendation": rec,
            "status": "SUCCESS",
            "reason": rec["reason"]
        })

    return planned_assignments


if __name__ == "__main__":
    import static_data

    print("=" * 65)
    print("CCMS PHASE 4: GREEDY ALGORITHM AUTO-ASSIGNMENT TEST")
    print("=" * 65)

    complaints = static_data.STATIC_COMPLAINTS
    officers = static_data.STATIC_OFFICERS

    # Pick an unassigned complaint or test sample
    test_complaint = complaints[1]  # CCMS-2026-1024 (Healthcare & Supplies)
    print(f"\nTarget Complaint: [{test_complaint['complaint_id']}] {test_complaint['complaint_title']}")
    print(f"Sector / Department: {test_complaint['sector']}")

    eligible, note = get_eligible_officers(test_complaint, officers)
    print(f"Eligibility Note: {note}")

    rec = recommend_officer(test_complaint, eligible, complaints)
    print(f"Status: {rec['status']}")
    print(f"Recommended Officer: {rec['recommended_officer']['name']} ({rec['recommended_officer']['officer_id']})")
    print(f"Active Workload: {rec['workload']}")
    print(f"Reason: {rec['reason']}")
    print("\nEvaluated Candidates:")
    for c in rec["evaluated_candidates"]:
        print(f"  • {c['name']} ({c['officer_id']}) - Workload: {c['workload']} active cases")
