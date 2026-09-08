"""
Unit Tests for CCMS DSA Core Engine
"""
import unittest
from dsa import (
    Node, SinglyLinkedList, LinkedStack, LinkedQueue, Queue,
    StackUnderflowError, QueueUnderflowError,
    ExpressionHandler, EfficiencyEngine
)

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


class TestLinkedStack(unittest.TestCase):
    def setUp(self):
        self.stack = LinkedStack()

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


class TestLinkedQueue(unittest.TestCase):
    def setUp(self):
        self.queue = LinkedQueue()

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
    def test_infix_to_postfix_and_eval(self):
        # 1. Simple expression: ( 10 + 20 ) * 3
        expr1 = "( 10 + 20 ) * 3"
        postfix1, trace1 = ExpressionHandler.infix_to_postfix(expr1)
        self.assertEqual(" ".join(postfix1), "10 20 + 3 *")
        res1, eval_trace1 = ExpressionHandler.evaluate_postfix(postfix1)
        self.assertEqual(res1, 90)

        # 2. CCMS Fine Formula: (5000 * 2) + (10 * 100) - 250
        expr2 = "( 5000 * 2 ) + ( 10 * 100 ) - 250"
        postfix2, trace2 = ExpressionHandler.infix_to_postfix(expr2)
        res2, _ = ExpressionHandler.evaluate_postfix(postfix2)
        self.assertEqual(res2, 10750)

        # 3. Exponentiation & Precedence: 2 + 3 * 4 ^ 2
        expr3 = "2 + 3 * 4 ^ 2"
        postfix3, _ = ExpressionHandler.infix_to_postfix(expr3)
        self.assertEqual(" ".join(postfix3), "2 3 4 2 ^ * +")
        res3, _ = ExpressionHandler.evaluate_postfix(postfix3)
        self.assertEqual(res3, 50)


class TestEfficiencyEngine(unittest.TestCase):
    def test_binary_search(self):
        arr = [10, 20, 30, 40, 50, 60, 70, 80]
        idx_iter, steps_i = EfficiencyEngine.iterative_binary_search(arr, 50)
        idx_rec, steps_r = EfficiencyEngine.recursive_binary_search(arr, 50, 0, len(arr) - 1)
        self.assertEqual(idx_iter, 4)
        self.assertEqual(idx_rec, 4)

    def test_factorial(self):
        val_i, _ = EfficiencyEngine.iterative_factorial(5)
        val_r, _ = EfficiencyEngine.recursive_factorial(5)
        self.assertEqual(val_i, 120)
        self.assertEqual(val_r, 120)

    def test_fibonacci(self):
        val_i, _ = EfficiencyEngine.iterative_fibonacci(7)
        val_r, _ = EfficiencyEngine.recursive_fibonacci(7)
        self.assertEqual(val_i, 13)
        self.assertEqual(val_r, 13)

    def test_benchmark_runner(self):
        bench = EfficiencyEngine.run_benchmark("binary_search", 100)
        self.assertIn("iterative", bench)
        self.assertIn("recursive", bench)
        self.assertEqual(bench["iterative"]["time_complexity"], "O(log N)")


if __name__ == "__main__":
    unittest.main()
