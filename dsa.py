"""
=============================================================================
CCMS DATA STRUCTURES & ALGORITHMS (DSA) CORE ENGINE
=============================================================================
This module provides pure Python implementations of core DSA concepts:
1. Singly Linked List for dynamic data storage (CRUD & search operations)
2. Linked-based Stack (LIFO) & Linked-based Queue (FIFO)
3. Stack-based Expression Handling (Infix to Postfix & Postfix Evaluation)
4. Efficiency Concept Demonstrations (Iterative vs. Recursive implementations
   with Time & Space complexity metrics and benchmark tracing)
=============================================================================
"""

import time
import re
from typing import Any, List, Optional, Tuple, Dict


# =============================================================================
# 1. NODE & SINGLY LINKED LIST (DATA STORAGE)
# =============================================================================

class Node:
    """Represents a single node in a linked data structure."""
    def __init__(self, data: Any):
        self.data = data
        self.next: Optional['Node'] = None

    def to_dict(self) -> Dict[str, Any]:
        return {
            "data": self.data,
            "has_next": self.next is not None
        }


class SinglyLinkedList:
    """
    Singly Linked List implementation for dynamic in-memory record storage.
    Supports basic operations: insert (head/tail), delete (by value/index),
    search, traversal, and size tracking.
    """
    def __init__(self):
        self.head: Optional[Node] = None
        self._size: int = 0

    def is_empty(self) -> bool:
        """Check if the linked list has no elements. Time Complexity: O(1)"""
        return self.head is None

    def get_size(self) -> int:
        """Return the number of nodes in the linked list. Time Complexity: O(1)"""
        return self._size

    def insert_at_head(self, data: Any) -> None:
        """
        Insert a new node at the beginning of the list.
        Time Complexity: O(1)
        Space Complexity: O(1)
        """
        new_node = Node(data)
        new_node.next = self.head
        self.head = new_node
        self._size += 1

    def insert_at_tail(self, data: Any) -> None:
        """
        Insert a new node at the end of the list.
        Time Complexity: O(N)
        Space Complexity: O(1)
        """
        new_node = Node(data)
        if self.head is None:
            self.head = new_node
        else:
            current = self.head
            while current.next is not None:
                current = current.next
            current.next = new_node
        self._size += 1

    # Alias for insert_at_tail
    append = insert_at_tail

    def delete_by_value(self, key: Any) -> bool:
        """
        Delete the first occurrence of a node whose data matches key (or key['id'] if dict).
        Time Complexity: O(N)
        Space Complexity: O(1)
        Returns True if deleted, False otherwise.
        """
        if self.head is None:
            return False

        # Helper to match key against node data (supports dict matching by 'id' or 'complaint_id')
        def matches(node_data, search_key):
            if isinstance(node_data, dict):
                return (node_data.get('id') == search_key or 
                        node_data.get('complaint_id') == search_key or 
                        str(node_data) == str(search_key))
            return node_data == search_key

        # Case 1: Head is the target
        if matches(self.head.data, key):
            self.head = self.head.next
            self._size -= 1
            return True

        # Case 2: Search in rest of the list
        current = self.head
        while current.next is not None:
            if matches(current.next.data, key):
                current.next = current.next.next
                self._size -= 1
                return True
            current = current.next

        return False

    def delete_at_index(self, index: int) -> Optional[Any]:
        """
        Delete a node at a specified 0-based index.
        Time Complexity: O(N)
        Space Complexity: O(1)
        Returns the data of the deleted node, or None if index is out of bounds.
        """
        if index < 0 or index >= self._size or self.head is None:
            return None

        if index == 0:
            deleted_data = self.head.data
            self.head = self.head.next
            self._size -= 1
            return deleted_data

        current = self.head
        for _ in range(index - 1):
            if current.next is None:
                return None
            current = current.next

        if current.next is None:
            return None

        deleted_data = current.next.data
        current.next = current.next.next
        self._size -= 1
        return deleted_data

    def search(self, key: Any) -> Optional[Tuple[int, Any]]:
        """
        Search for an item by value or ID.
        Time Complexity: O(N)
        Space Complexity: O(1)
        Returns (index, data) tuple if found, otherwise None.
        """
        def matches(node_data, search_key):
            if isinstance(node_data, dict):
                return (str(node_data.get('id', '')).lower() == str(search_key).lower() or
                        str(node_data.get('complaint_id', '')).lower() == str(search_key).lower() or
                        str(search_key).lower() in str(node_data.get('title', '')).lower())
            return str(node_data).lower() == str(search_key).lower()

        current = self.head
        index = 0
        while current is not None:
            if matches(current.data, key):
                return (index, current.data)
            current = current.next
            index += 1
        return None

    def traverse(self) -> List[Any]:
        """
        Traverse the linked list and return a list of all elements.
        Time Complexity: O(N)
        Space Complexity: O(N)
        """
        elements = []
        current = self.head
        while current is not None:
            elements.append(current.data)
            current = current.next
        return elements

    def to_list(self) -> List[Dict[str, Any]]:
        """
        Convert linked list to visual node structure list for frontend display.
        """
        nodes = []
        current = self.head
        idx = 0
        while current is not None:
            nodes.append({
                "index": idx,
                "data": current.data,
                "has_next": current.next is not None
            })
            current = current.next
            idx += 1
        return nodes

    def clear(self) -> None:
        """Reset the list."""
        self.head = None
        self._size = 0


# =============================================================================
# 2. LINKED-BASED STACK & QUEUE
# =============================================================================

class StackUnderflowError(Exception):
    """Exception raised when popping from an empty stack."""
    pass


class QueueUnderflowError(Exception):
    """Exception raised when dequeueing from an empty queue."""
    pass


class LinkedStack:
    """
    Linked-based (Node-based) Stack implementation (LIFO - Last In First Out).
    All basic operations (push, pop, peek, is_empty) execute in O(1) time.
    """
    def __init__(self):
        self.top: Optional[Node] = None
        self._size: int = 0

    def is_empty(self) -> bool:
        """Time Complexity: O(1)"""
        return self.top is None

    def size(self) -> int:
        """Time Complexity: O(1)"""
        return self._size

    def push(self, item: Any) -> None:
        """
        Push an item onto the top of the stack.
        Time Complexity: O(1)
        Space Complexity: O(1)
        """
        new_node = Node(item)
        new_node.next = self.top
        self.top = new_node
        self._size += 1

    def pop(self) -> Any:
        """
        Remove and return the top item from the stack.
        Time Complexity: O(1)
        Space Complexity: O(1)
        Raises StackUnderflowError if the stack is empty.
        """
        if self.is_empty():
            raise StackUnderflowError("Cannot pop from an empty stack.")
        popped_item = self.top.data
        self.top = self.top.next
        self._size -= 1
        return popped_item

    def peek(self) -> Any:
        """
        Return the top item without removing it.
        Time Complexity: O(1)
        Raises StackUnderflowError if the stack is empty.
        """
        if self.is_empty():
            raise StackUnderflowError("Cannot peek into an empty stack.")
        return self.top.data

    def to_list(self) -> List[Any]:
        """Return stack elements from top to bottom."""
        items = []
        current = self.top
        while current is not None:
            items.append(current.data)
            current = current.next
        return items


class LinkedQueue:
    """
    Linked-based (Node-based) Queue implementation (FIFO - First In First Out).
    Maintains front and rear pointers for O(1) enqueue and dequeue operations.
    """
    def __init__(self):
        self.front: Optional[Node] = None
        self.rear: Optional[Node] = None
        self._size: int = 0

    def is_empty(self) -> bool:
        """Time Complexity: O(1)"""
        return self.front is None

    def size(self) -> int:
        """Time Complexity: O(1)"""
        return self._size

    def enqueue(self, item: Any) -> None:
        """
        Add an item to the rear of the queue.
        Time Complexity: O(1)
        Space Complexity: O(1)
        """
        new_node = Node(item)
        if self.rear is None:
            self.front = new_node
            self.rear = new_node
        else:
            self.rear.next = new_node
            self.rear = new_node
        self._size += 1

    def dequeue(self) -> Any:
        """
        Remove and return the front item from the queue.
        Time Complexity: O(1)
        Space Complexity: O(1)
        Raises QueueUnderflowError if the queue is empty.
        """
        if self.is_empty():
            raise QueueUnderflowError("Cannot dequeue from an empty queue.")
        dequeued_item = self.front.data
        self.front = self.front.next
        if self.front is None:
            self.rear = None
        self._size -= 1
        return dequeued_item

    def peek(self) -> Any:
        """
        Return the front item without removing it.
        Time Complexity: O(1)
        Raises QueueUnderflowError if the queue is empty.
        """
        if self.is_empty():
            raise QueueUnderflowError("Cannot peek into an empty queue.")
        return self.front.data

    def to_list(self) -> List[Any]:
        """Return queue elements from front to rear."""
        items = []
        current = self.front
        while current is not None:
            items.append(current.data)
            current = current.next
        return items


# =============================================================================
# 3. EXPRESSION HANDLING USING STACK (INFIX TO POSTFIX & EVALUATION)
# =============================================================================

class ExpressionHandler:
    """
    Applies LinkedStack to convert Infix mathematical expressions to Postfix
    (Reverse Polish Notation) and evaluate Postfix expressions step-by-step.
    Supports operators: +, -, *, /, ^, parentheses, and variable substitution
    for CCMS penalty & risk calculation formulas.
    """
    OPERATOR_PRECEDENCE = {
        '+': 1,
        '-': 1,
        '*': 2,
        '/': 2,
        '^': 3
    }

    @classmethod
    def tokenize(cls, expression: str) -> List[str]:
        """
        Splits an expression string into tokens (operands, operators, parentheses).
        Example: "(2500 * 2) + 150" -> ['(', '2500', '*', '2', ')', '+', '150']
        """
        # Match numbers (float/int), alphanumeric identifiers/variables, or operators/parentheses
        token_pattern = r'\d+(?:\.\d+)?|[a-zA-Z_]\w*|[+\-*/^()]'
        tokens = re.findall(token_pattern, expression)
        return tokens

    @classmethod
    def infix_to_postfix(cls, expression: str, variables: Optional[Dict[str, float]] = None) -> Tuple[List[str], List[Dict[str, Any]]]:
        """
        Converts an Infix expression into Postfix notation using LinkedStack.
        Returns:
            postfix_tokens: List of tokens in postfix order
            trace_steps: Step-by-step trace log of token, stack state, and output buffer
        """
        tokens = cls.tokenize(expression)
        stack = LinkedStack()
        postfix = []
        trace_steps = []

        # Substitute variable names if supplied
        var_dict = variables or {}

        for token in tokens:
            # If token is a variable, resolve it to value
            resolved_token = token
            if token in var_dict:
                resolved_token = str(var_dict[token])

            # 1. If operand (number or unresolved variable), add directly to output
            if re.match(r'^-?\d+(?:\.\d+)?$', resolved_token) or (resolved_token.isalpha() and resolved_token not in cls.OPERATOR_PRECEDENCE):
                postfix.append(resolved_token)
                action = f"Operand '{resolved_token}' appended to output"

            # 2. If left parenthesis '(', push to stack
            elif token == '(':
                stack.push(token)
                action = "Pushed '(' onto stack"

            # 3. If right parenthesis ')', pop from stack to output until '('
            elif token == ')':
                action = "Popped operators from stack to output until '('"
                while not stack.is_empty() and stack.peek() != '(':
                    postfix.append(stack.pop())
                if not stack.is_empty() and stack.peek() == '(':
                    stack.pop()  # discard '('
                else:
                    raise ValueError("Mismatched parentheses in expression.")

            # 4. If operator, pop operators of greater or equal precedence, then push
            elif token in cls.OPERATOR_PRECEDENCE:
                prec = cls.OPERATOR_PRECEDENCE[token]
                while (not stack.is_empty() and 
                       stack.peek() != '(' and 
                       cls.OPERATOR_PRECEDENCE.get(stack.peek(), 0) >= prec):
                    postfix.append(stack.pop())
                stack.push(token)
                action = f"Pushed operator '{token}' (precedence {prec}) onto stack"
            else:
                postfix.append(resolved_token)
                action = f"Appended identifier '{resolved_token}' to output"

            # Record step trace for visualization
            trace_steps.append({
                "token": token,
                "action": action,
                "stack": stack.to_list(),
                "output": " ".join(postfix)
            })

        # Pop any remaining operators on the stack
        while not stack.is_empty():
            top = stack.pop()
            if top in ('(', ')'):
                raise ValueError("Mismatched parentheses in expression.")
            postfix.append(top)
            trace_steps.append({
                "token": "<EOF>",
                "action": f"Popped remaining operator '{top}' to output",
                "stack": stack.to_list(),
                "output": " ".join(postfix)
            })

        return postfix, trace_steps

    @classmethod
    def evaluate_postfix(cls, postfix_tokens: List[str]) -> Tuple[float, List[Dict[str, Any]]]:
        """
        Evaluates a Postfix expression using LinkedStack.
        Returns:
            final_result: Computed numeric value
            eval_trace: Step-by-step trace showing operand stack transitions
        """
        stack = LinkedStack()
        eval_trace = []

        for token in postfix_tokens:
            # Check if token is a number
            if re.match(r'^-?\d+(?:\.\d+)?$', token):
                num_val = float(token) if '.' in token else int(token)
                stack.push(num_val)
                action = f"Pushed operand {num_val} onto evaluation stack"
            elif token in cls.OPERATOR_PRECEDENCE:
                if stack.size() < 2:
                    raise ValueError(f"Insufficient operands for operator '{token}'")
                b = stack.pop()
                a = stack.pop()

                if token == '+':
                    res = a + b
                elif token == '-':
                    res = a - b
                elif token == '*':
                    res = a * b
                elif token == '/':
                    if b == 0:
                        raise ZeroDivisionError("Division by zero in formula evaluation.")
                    res = a / b
                elif token == '^':
                    res = a ** b
                else:
                    raise ValueError(f"Unsupported operator '{token}'")

                # Round clean numbers
                if isinstance(res, float) and res.is_integer():
                    res = int(res)
                elif isinstance(res, float):
                    res = round(res, 4)

                stack.push(res)
                action = f"Computed ({a} {token} {b}) = {res}, pushed result onto stack"
            else:
                raise ValueError(f"Cannot evaluate non-numeric token '{token}'")

            eval_trace.append({
                "token": token,
                "action": action,
                "stack": stack.to_list()
            })

        if stack.size() != 1:
            raise ValueError("Invalid postfix expression: multiple items remain on stack.")

        return stack.pop(), eval_trace


# =============================================================================
# 4. EFFICIENCY CONCEPTS: ITERATIVE VS. RECURSIVE IMPLEMENTATIONS
# =============================================================================

class EfficiencyEngine:
    """
    Demonstrates and benchmarks basic efficiency concepts (Iterative vs. Recursive)
    applied to CCMS domain operations. Compares Time Complexity, Auxiliary Space,
    execution times (microseconds), and recursive call-stack depths.
    """

    # -------------------------------------------------------------------------
    # 4.1 Binary Search (Case ID Search)
    # -------------------------------------------------------------------------
    @staticmethod
    def iterative_binary_search(arr: List[Any], target: Any) -> Tuple[int, int]:
        """
        Iterative Binary Search.
        Time Complexity: O(log N)
        Auxiliary Space Complexity: O(1)
        Returns (index_found_or_minus_1, steps_count)
        """
        low = 0
        high = len(arr) - 1
        steps = 0

        while low <= high:
            steps += 1
            mid = (low + high) // 2
            if arr[mid] == target:
                return mid, steps
            elif arr[mid] < target:
                low = mid + 1
            else:
                high = mid - 1

        return -1, steps

    @staticmethod
    def recursive_binary_search(arr: List[Any], target: Any, low: int, high: int, steps: int = 0) -> Tuple[int, int]:
        """
        Recursive Binary Search.
        Time Complexity: O(log N)
        Auxiliary Space Complexity: O(log N) due to recursive call stack
        Returns (index_found_or_minus_1, steps_count)
        """
        steps += 1
        if low > high:
            return -1, steps

        mid = (low + high) // 2
        if arr[mid] == target:
            return mid, steps
        elif arr[mid] < target:
            return EfficiencyEngine.recursive_binary_search(arr, target, mid + 1, high, steps)
        else:
            return EfficiencyEngine.recursive_binary_search(arr, target, low, mid - 1, steps)

    # -------------------------------------------------------------------------
    # 4.2 Severity Multiplier / Factorial (Legal Fine Escalation)
    # -------------------------------------------------------------------------
    @staticmethod
    def iterative_factorial(n: int) -> Tuple[int, int]:
        """
        Iterative Factorial calculation for multi-tier penalty multipliers.
        Time Complexity: O(N)
        Auxiliary Space Complexity: O(1)
        """
        if n < 0:
            raise ValueError("Factorial undefined for negative numbers.")
        result = 1
        steps = 0
        for i in range(2, n + 1):
            steps += 1
            result *= i
        return result, max(1, steps)

    @staticmethod
    def recursive_factorial(n: int, steps: int = 0) -> Tuple[int, int]:
        """
        Recursive Factorial calculation with call stack depth tracking.
        Time Complexity: O(N)
        Auxiliary Space Complexity: O(N) due to call stack
        """
        steps += 1
        if n < 0:
            raise ValueError("Factorial undefined for negative numbers.")
        if n <= 1:
            return 1, steps
        sub_res, final_steps = EfficiencyEngine.recursive_factorial(n - 1, steps)
        return n * sub_res, final_steps

    # -------------------------------------------------------------------------
    # 4.3 SLA Escalation Curve / Fibonacci (Investigation Escalation Delay)
    # -------------------------------------------------------------------------
    @staticmethod
    def iterative_fibonacci(n: int) -> Tuple[int, int]:
        """
        Iterative Fibonacci calculation for dynamic SLA response intervals.
        Time Complexity: O(N)
        Auxiliary Space Complexity: O(1)
        """
        if n <= 0:
            return 0, 1
        if n == 1:
            return 1, 1

        a, b = 0, 1
        steps = 0
        for _ in range(2, n + 1):
            steps += 1
            a, b = b, a + b
        return b, steps

    @staticmethod
    def recursive_fibonacci(n: int, steps_ref: Optional[List[int]] = None) -> Tuple[int, int]:
        """
        Recursive Fibonacci calculation (Naïve Recursion to demonstrate exponential tree growth).
        Time Complexity: O(2^N)
        Auxiliary Space Complexity: O(N) maximum call stack depth
        """
        if steps_ref is None:
            steps_ref = [0]
        steps_ref[0] += 1

        if n <= 0:
            return 0, steps_ref[0]
        if n == 1:
            return 1, steps_ref[0]

        val1, _ = EfficiencyEngine.recursive_fibonacci(n - 1, steps_ref)
        val2, _ = EfficiencyEngine.recursive_fibonacci(n - 2, steps_ref)
        return val1 + val2, steps_ref[0]

    # -------------------------------------------------------------------------
    # 4.4 Linked List Traversal & Length (Iterative vs Recursive)
    # -------------------------------------------------------------------------
    @staticmethod
    def iterative_list_length(head: Optional[Node]) -> Tuple[int, int]:
        """
        Iterative Linked List Length counter.
        Time: O(N), Space: O(1)
        """
        count = 0
        current = head
        while current is not None:
            count += 1
            current = current.next
        return count, count

    @staticmethod
    def recursive_list_length(head: Optional[Node], depth: int = 0) -> Tuple[int, int]:
        """
        Recursive Linked List Length counter.
        Time: O(N), Space: O(N) call stack
        """
        if head is None:
            return 0, depth
        sub_len, max_depth = EfficiencyEngine.recursive_list_length(head.next, depth + 1)
        return 1 + sub_len, max_depth

    # -------------------------------------------------------------------------
    # 4.5 Comparative Benchmark Runner
    # -------------------------------------------------------------------------
    @classmethod
    def run_benchmark(cls, algorithm_type: str, input_value: int) -> Dict[str, Any]:
        """
        Runs and times both Iterative and Recursive versions of the selected algorithm.
        Returns detailed comparison data including microsecond execution times,
        step counts, space complexity, and analytical findings.
        """
        result = {
            "algorithm": algorithm_type,
            "input_n": input_value,
            "iterative": {},
            "recursive": {},
            "analysis": {}
        }

        # Case 1: Binary Search
        if algorithm_type == "binary_search":
            data_arr = list(range(1, input_value + 1))
            target = input_value // 2  # Middle element search

            # Time iterative
            t0 = time.perf_counter_ns()
            idx_iter, steps_iter = cls.iterative_binary_search(data_arr, target)
            t1 = time.perf_counter_ns()
            time_iter_us = (t1 - t0) / 1000.0

            # Time recursive
            t0 = time.perf_counter_ns()
            idx_rec, steps_rec = cls.recursive_binary_search(data_arr, target, 0, len(data_arr) - 1)
            t1 = time.perf_counter_ns()
            time_rec_us = (t1 - t0) / 1000.0

            result["iterative"] = {
                "result": f"Found at index {idx_iter}",
                "steps": steps_iter,
                "time_us": round(time_iter_us, 3),
                "time_complexity": "O(log N)",
                "space_complexity": "O(1) [Constant Memory]"
            }
            result["recursive"] = {
                "result": f"Found at index {idx_rec}",
                "steps": steps_rec,
                "time_us": round(time_rec_us, 3),
                "time_complexity": "O(log N)",
                "space_complexity": "O(log N) [Call Stack Frames]"
            }
            result["analysis"] = {
                "winner": "Iterative",
                "explanation": "Iterative avoids function call overhead and maintains O(1) auxiliary space, whereas recursive creates log(N) stack frames."
            }

        # Case 2: Factorial
        elif algorithm_type == "factorial":
            n = min(input_value, 20)  # Bound to 20 for factorial readability

            t0 = time.perf_counter_ns()
            val_iter, steps_iter = cls.iterative_factorial(n)
            t1 = time.perf_counter_ns()
            time_iter_us = (t1 - t0) / 1000.0

            t0 = time.perf_counter_ns()
            val_rec, steps_rec = cls.recursive_factorial(n)
            t1 = time.perf_counter_ns()
            time_rec_us = (t1 - t0) / 1000.0

            result["iterative"] = {
                "result": str(val_iter),
                "steps": steps_iter,
                "time_us": round(time_iter_us, 3),
                "time_complexity": "O(N)",
                "space_complexity": "O(1) [Constant]"
            }
            result["recursive"] = {
                "result": str(val_rec),
                "steps": steps_rec,
                "time_us": round(time_rec_us, 3),
                "time_complexity": "O(N)",
                "space_complexity": f"O(N) [{steps_rec} Stack Frames]"
            }
            result["analysis"] = {
                "winner": "Iterative",
                "explanation": f"For N={n}, recursive uses {steps_rec} stack frames on the call stack, while iterative uses a single loop register."
            }

        # Case 3: Fibonacci
        elif algorithm_type == "fibonacci":
            n = min(input_value, 30)  # Bound to 30 to prevent recursive explosion

            t0 = time.perf_counter_ns()
            val_iter, steps_iter = cls.iterative_fibonacci(n)
            t1 = time.perf_counter_ns()
            time_iter_us = (t1 - t0) / 1000.0

            t0 = time.perf_counter_ns()
            val_rec, steps_rec = cls.recursive_fibonacci(n)
            t1 = time.perf_counter_ns()
            time_rec_us = (t1 - t0) / 1000.0

            result["iterative"] = {
                "result": str(val_iter),
                "steps": steps_iter,
                "time_us": round(time_iter_us, 3),
                "time_complexity": "O(N)",
                "space_complexity": "O(1) [Constant]"
            }
            result["recursive"] = {
                "result": str(val_rec),
                "steps": steps_rec,
                "time_us": round(time_rec_us, 3),
                "time_complexity": "O(2^N) [Exponential]",
                "space_complexity": f"O(N) Stack Depth, {steps_rec} Total Invocations"
            }
            result["analysis"] = {
                "winner": "Iterative (Massive Advantage)",
                "explanation": f"Naïve recursion requires {steps_rec} recursive function calls due to overlapping subproblems (O(2^N)), whereas iterative loops in only {steps_iter} steps (O(N))."
            }

        # Case 4: Linked List Traversal
        elif algorithm_type == "linked_list_length":
            # Build sample linked list of size input_value
            ll = SinglyLinkedList()
            for i in range(input_value):
                ll.insert_at_head(i)

            t0 = time.perf_counter_ns()
            len_iter, steps_iter = cls.iterative_list_length(ll.head)
            t1 = time.perf_counter_ns()
            time_iter_us = (t1 - t0) / 1000.0

            t0 = time.perf_counter_ns()
            len_rec, depth_rec = cls.recursive_list_length(ll.head)
            t1 = time.perf_counter_ns()
            time_rec_us = (t1 - t0) / 1000.0

            result["iterative"] = {
                "result": f"Length: {len_iter}",
                "steps": steps_iter,
                "time_us": round(time_iter_us, 3),
                "time_complexity": "O(N)",
                "space_complexity": "O(1) [Single Pointer Traversal]"
            }
            result["recursive"] = {
                "result": f"Length: {len_rec}",
                "steps": depth_rec,
                "time_us": round(time_rec_us, 3),
                "time_complexity": "O(N)",
                "space_complexity": f"O(N) [{depth_rec} Stack Frames]"
            }
            result["analysis"] = {
                "winner": "Iterative",
                "explanation": "Iterative pointer traversal operates with O(1) auxiliary space without risking Python RecursionError stack overflows on large datasets."
            }

        return result
