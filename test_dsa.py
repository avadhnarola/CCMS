"""
Unit Tests for CCMS DSA Core Engine (Phase 1 & Phase 2)
======================================================
Comprehensive test suite verifying all linear data structures,
expression handling, efficiency benchmarks, binary trees, BSTs, and graphs.
"""
import unittest
from dsa import (
    SAMPLE_NUMERIC_DATASET, SAMPLE_SECTORS_DATASET, SAMPLE_COMPLAINT_RECORDS,
    Node, SinglyLinkedList, Stack, Queue, Queue,
    StackUnderflowError, QueueUnderflowError,
    ExpressionHandler, EfficiencyEngine,
    BinaryTreeNode, BinaryTree,
    BSTNode, BinarySearchTree,
    Graph,
    build_default_vigilance_tree, build_default_complaints_bst, build_default_escalation_graph
)


# ==============================================================================
# PHASE 1 TESTS
# ==============================================================================
class TestPhase1Datasets(unittest.TestCase):
    def test_datasets_exist(self):
        self.assertGreater(len(SAMPLE_NUMERIC_DATASET), 0)
        self.assertGreater(len(SAMPLE_SECTORS_DATASET), 0)
        self.assertGreater(len(SAMPLE_COMPLAINT_RECORDS), 0)
        self.assertIn("id", SAMPLE_COMPLAINT_RECORDS[0])


class TestSinglyLinkedList(unittest.TestCase):
    def setUp(self):
        self.ll = SinglyLinkedList()

    def test_insert_head_and_tail(self):
        self.assertTrue(self.ll.is_empty())
        self.assertEqual(self.ll.get_size(), 0)

        self.ll.insert_at_head({"id": "CCMS-001", "title": "Bribe case"})
        self.ll.insert_at_tail({"id": "CCMS-002", "title": "Scam case"})
        self.ll.insert_at_head({"id": "CCMS-000", "title": "Land case"})

        self.assertEqual(self.ll.get_size(), 3)
        items = self.ll.traverse()
        self.assertEqual(items[0]["id"], "CCMS-000")
        self.assertEqual(items[1]["id"], "CCMS-001")
        self.assertEqual(items[2]["id"], "CCMS-002")

    def test_delete_by_value(self):
        self.ll.insert_at_tail("A")
        self.ll.insert_at_tail("B")
        self.ll.insert_at_tail("C")

        # Delete middle
        deleted = self.ll.delete_by_value("B")
        self.assertTrue(deleted)
        self.assertEqual(self.ll.traverse(), ["A", "C"])
        self.assertEqual(self.ll.get_size(), 2)

        # Delete head
        deleted = self.ll.delete_by_value("A")
        self.assertTrue(deleted)
        self.assertEqual(self.ll.traverse(), ["C"])

        # Delete non-existent
        deleted = self.ll.delete_by_value("Z")
        self.assertFalse(deleted)

    def test_delete_at_index(self):
        self.ll.insert_at_tail("A")
        self.ll.insert_at_tail("B")
        self.ll.insert_at_tail("C")

        deleted = self.ll.delete_at_index(1)
        self.assertEqual(deleted, "B")
        self.assertEqual(self.ll.get_size(), 2)

        deleted_head = self.ll.delete_at_index(0)
        self.assertEqual(deleted_head, "A")
        self.assertEqual(self.ll.get_size(), 1)

    def test_search(self):
        self.ll.insert_at_tail({"id": "CCMS-2026-101", "title": "Tender Fraud"})
        self.ll.insert_at_tail({"id": "CCMS-2026-102", "title": "Police Misconduct"})

        found = self.ll.search("CCMS-2026-102")
        self.assertIsNotNone(found)
        index, data = found
        self.assertEqual(index, 1)
        self.assertEqual(data["title"], "Police Misconduct")

        not_found = self.ll.search("NON-EXISTENT")
        self.assertIsNone(not_found)

    def test_to_list(self):
        self.ll.insert_at_tail("X")
        self.ll.insert_at_tail("Y")
        nodes = self.ll.to_list()
        self.assertEqual(len(nodes), 2)
        self.assertTrue(nodes[0]["has_next"])
        self.assertFalse(nodes[1]["has_next"])


class TestStack(unittest.TestCase):
    def setUp(self):
        self.stack = Stack()

    def test_stack_operations(self):
        self.assertTrue(self.stack.is_empty())
        self.assertEqual(self.stack.size(), 0)

        self.stack.push("Case-1")
        self.stack.push("Case-2")
        self.stack.push("Case-3")

        self.assertEqual(self.stack.size(), 3)
        self.assertEqual(self.stack.peek(), "Case-3")
        self.assertEqual(self.stack.pop(), "Case-3")
        self.assertEqual(self.stack.pop(), "Case-2")
        self.assertEqual(self.stack.pop(), "Case-1")

        self.assertTrue(self.stack.is_empty())
        with self.assertRaises(StackUnderflowError):
            self.stack.pop()


class TestQueue(unittest.TestCase):
    def setUp(self):
        self.queue = Queue()

    def test_queue_operations(self):
        self.assertTrue(self.queue.is_empty())
        self.assertEqual(self.queue.size(), 0)

        self.queue.enqueue("Citizen-A")
        self.queue.enqueue("Citizen-B")
        self.queue.enqueue("Citizen-C")

        self.assertEqual(self.queue.size(), 3)
        self.assertEqual(self.queue.peek(), "Citizen-A")
        self.assertEqual(self.queue.dequeue(), "Citizen-A")
        self.assertEqual(self.queue.dequeue(), "Citizen-B")
        self.assertEqual(self.queue.dequeue(), "Citizen-C")

        self.assertTrue(self.queue.is_empty())
        with self.assertRaises(QueueUnderflowError):
            self.queue.dequeue()


class TestExpressionHandler(unittest.TestCase):
    def test_infix_to_postfix_and_evaluation(self):
        expr = "( 5000 * 2 ) + ( 15 * 100 ) - 500"
        result, postfix, infix_trace, eval_trace = ExpressionHandler.calculate(expr)

        self.assertEqual(result, 11000)
        self.assertEqual(postfix, "5000 2 * 15 100 * + 500 -")
        self.assertGreater(len(infix_trace), 0)
        self.assertGreater(len(eval_trace), 0)

    def test_simple_precedence(self):
        expr = "10 + 20 * 3"
        tokens, _ = ExpressionHandler.infix_to_postfix(expr)
        result, _ = ExpressionHandler.evaluate_postfix(tokens)
        self.assertEqual(result, 70)


class TestEfficiencyEngine(unittest.TestCase):
    def test_binary_search(self):
        arr = [10, 20, 30, 40, 50, 60, 70, 80]
        vi, si = EfficiencyEngine.iterative_binary_search(arr, 40)
        vr, sr = EfficiencyEngine.recursive_binary_search(arr, 40)
        self.assertEqual(vi, 3)
        self.assertEqual(vr, 3)

    def test_factorial(self):
        vi, _ = EfficiencyEngine.iterative_factorial(5)
        vr, _ = EfficiencyEngine.recursive_factorial(5)
        self.assertEqual(vi, 120)
        self.assertEqual(vr, 120)

    def test_fibonacci(self):
        vi, _ = EfficiencyEngine.iterative_fibonacci(7)
        vr, _ = EfficiencyEngine.recursive_fibonacci(7)
        self.assertEqual(vi, 13)
        self.assertEqual(vr, 13)

    def test_run_benchmark(self):
        b = EfficiencyEngine.run_benchmark("factorial", 8)
        self.assertIn("iterative", b)
        self.assertIn("recursive", b)
        self.assertIn("analysis", b)
        self.assertIn("time_complexity", b["iterative"])


# ==============================================================================
# PHASE 2 TESTS
# ==============================================================================
class TestBinaryTree(unittest.TestCase):
    def setUp(self):
        self.tree = build_default_vigilance_tree()

    def test_tree_structure(self):
        self.assertIsNotNone(self.tree.root)
        self.assertEqual(self.tree.root.value, "Central Vigilance Directorate (HQ)")
        self.assertEqual(self.tree.get_height(), 3)
        self.assertEqual(self.tree.count_nodes(), 7)

    def test_traversals(self):
        inorder = self.tree.inorder_traversal()
        preorder = self.tree.preorder_traversal()
        postorder = self.tree.postorder_traversal()
        level_order = self.tree.level_order_traversal()

        self.assertEqual(len(inorder), 7)
        self.assertEqual(len(preorder), 7)
        self.assertEqual(len(postorder), 7)
        self.assertEqual(len(level_order), 7)

        # Preorder starts with Root
        self.assertEqual(preorder[0], "Central Vigilance Directorate (HQ)")
        # Postorder ends with Root
        self.assertEqual(postorder[-1], "Central Vigilance Directorate (HQ)")
        # Level order starts with Root
        self.assertEqual(level_order[0], "Central Vigilance Directorate (HQ)")


class TestBinarySearchTree(unittest.TestCase):
    def setUp(self):
        self.bst = BinarySearchTree()
        self.bst.insert(50, {"title": "Medium Risk"})
        self.bst.insert(30, {"title": "Low Risk"})
        self.bst.insert(70, {"title": "High Risk"})
        self.bst.insert(20, {"title": "Very Low Risk"})
        self.bst.insert(40, {"title": "Moderate Risk"})
        self.bst.insert(60, {"title": "Elevated Risk"})
        self.bst.insert(80, {"title": "Critical Risk"})

    def test_search(self):
        node = self.bst.search(70)
        self.assertIsNotNone(node)
        self.assertEqual(node.data["title"], "High Risk")

        not_found = self.bst.search(999)
        self.assertIsNone(not_found)

    def test_inorder_sorted(self):
        sorted_records = self.bst.inorder_traversal()
        keys = [r["key"] for r in sorted_records]
        self.assertEqual(keys, [20, 30, 40, 50, 60, 70, 80])

    def test_min_and_max(self):
        self.assertEqual(self.bst.find_min().key, 20)
        self.assertEqual(self.bst.find_max().key, 80)

    def test_delete_nodes(self):
        # 1. Delete leaf node
        self.assertTrue(self.bst.delete(20))
        self.assertIsNone(self.bst.search(20))

        # 2. Delete node with 2 children
        self.assertTrue(self.bst.delete(70))
        self.assertIsNone(self.bst.search(70))
        sorted_keys = [r["key"] for r in self.bst.inorder_traversal()]
        self.assertEqual(sorted_keys, [30, 40, 50, 60, 80])


class TestGraphAndTraversals(unittest.TestCase):
    def setUp(self):
        self.g = build_default_escalation_graph()

    def test_graph_vertices_and_edges(self):
        vertices = self.g.get_vertices()
        self.assertIn("Citizen Front Desk", vertices)
        self.assertIn("Central Vigilance Directorate", vertices)
        neighbors = self.g.get_neighbors("Citizen Front Desk")
        self.assertIn("Triage & Verification Desk", neighbors)

    def test_bfs_traversal(self):
        path, trace = self.g.bfs("Citizen Front Desk")
        self.assertEqual(path[0], "Citizen Front Desk")
        self.assertIn("Triage & Verification Desk", path)
        self.assertIn("Central Vigilance Directorate", path)
        self.assertGreater(len(trace), 0)

    def test_dfs_traversal(self):
        path, trace = self.g.dfs("Citizen Front Desk")
        self.assertEqual(path[0], "Citizen Front Desk")
        self.assertEqual(len(path), len(self.g.get_vertices()))
        self.assertGreater(len(trace), 0)


class TestDatasetBuilders(unittest.TestCase):
    def test_dataset_tree_and_bst(self):
        from dsa import build_dataset_vigilance_tree, build_dataset_complaints_bst, build_dataset_escalation_graph
        depts = [
            {"dept_id": "DEPT-01", "name": "Police & Law Enforcement", "head": "Comm. Rao", "total_cases": 42, "risk_level": "High"},
            {"dept_id": "DEPT-03", "name": "Municipality & Public Works", "head": "Eng. Gupta", "total_cases": 51, "risk_level": "High"}
        ]
        tree = build_dataset_vigilance_tree(depts)
        self.assertIsNotNone(tree.root)
        self.assertEqual(tree.root.value, "Central Vigilance Directorate (HQ)")

        complaints = [
            {"complaint_id": "CCMS-001", "complaint_title": "Bribe", "severity": "Critical", "sector": "Police"},
            {"complaint_id": "CCMS-002", "complaint_title": "Embezzlement", "severity": "Medium", "sector": "PWD"}
        ]
        bst = build_dataset_complaints_bst(complaints)
        self.assertEqual(bst.size(), 2)
        self.assertIsNotNone(bst.find_min())
        self.assertIsNotNone(bst.find_max())

        graph = build_dataset_escalation_graph(depts)
        self.assertIn("Police & Law Enforcement", graph.get_vertices())


if __name__ == "__main__":
    unittest.main()
