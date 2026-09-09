"""
CCMS DSA Core Engine
====================
Contains core data structures and algorithms used across the Vigilance CCMS:
1. SinglyLinkedList: Sequential case record chaining and traversal
2. LinkedStack: LIFO structure for admin activity audit logs
3. LinkedQueue: FIFO structure for citizen complaint dispatch queue
4. ExpressionHandler: Infix to Postfix conversion and RPN evaluation
5. EfficiencyEngine: Iterative vs Recursive algorithmic benchmarks
"""
import time
import re
# ==============================================================================
# SAMPLE DATASETS
# ==============================================================================
SAMPLE_NUMERIC_DATASET = [10, 25, 42, 55, 78, 99, 120, 150, 200]
SAMPLE_SECTORS_DATASET = [
    "Bribery & Cash Demands",
    "Land Scam & Title Fraud",
    "Medical Supply Embezzlement",
    "Police Misconduct & Extortion",
    "Procurement & Tender Fraud",
    "Road & Construction Scam"
]

SAMPLE_COMPLAINT_RECORDS = [
    {
        "id": "CCMS-2026-2237",
        "title": "Demand 1000₹",
        "sector": "Bribe",
        "severity": "High",
        "status": "Under Investigation",
        "timestamp": "2026-09-01 09:15"
    },
    {
        "id": "CCMS-2026-102",
        "title": "Procurement Tender Bribery in Medical Supplies",
        "sector": "Health Services",
        "severity": "Critical",
        "status": "Pending Verification",
        "timestamp": "2026-09-01 10:30"
    },
    {
        "id": "CCMS-2026-103",
        "title": "Unauthorized Commercial Building Kickback",
        "sector": "Municipal Corp",
        "severity": "Medium",
        "status": "Assigned",
        "timestamp": "2026-09-01 11:45"
    },
    {
        "id": "CCMS-2026-104",
        "title": "Embezzlement of Public School Renovation Funds",
        "sector": "Education",
        "severity": "High",
        "status": "Pending Triage",
        "timestamp": "2026-09-01 14:20"
    }
]


# ==============================================================================
# CUSTOM EXCEPTIONS
# ==============================================================================
class StackUnderflowError(Exception):
    """Raised when an operation is performed on an empty stack."""
    pass


class QueueUnderflowError(Exception):
    """Raised when an operation is performed on an empty queue."""
    pass


# ==============================================================================
# BASE NODE CLASS
# ==============================================================================
class Node:
    """Singly Linked Node used in LinkedList, Stack, and Queue structures."""
    def __init__(self, data):
        self.data = data
        self.next = None


# ==============================================================================
# 1. SINGLY LINKED LIST DATA STRUCTURE
# ==============================================================================
class SinglyLinkedList:
    """Singly Linked List for dynamic sequential storage of case records."""

    def __init__(self):
        self.head = None
        self._size = 0

    def is_empty(self):
        return self.head is None

    def get_size(self):
        return self._size

    def size(self):
        return self._size

    def insert_at_head(self, data):
        new_node = Node(data)
        new_node.next = self.head
        self.head = new_node
        self._size += 1

    def insert_at_tail(self, data):
        new_node = Node(data)
        if self.head is None:
            self.head = new_node
        else:
            current = self.head
            while current.next:
                current = current.next
            current.next = new_node
        self._size += 1

    def delete_by_value(self, key):
        if self.head is None:
            return False

        # Match direct value or dict id
        if self.head.data == key or (isinstance(self.head.data, dict) and self.head.data.get('id') == key):
            self.head = self.head.next
            self._size -= 1
            return True

        current = self.head
        while current.next:
            if current.next.data == key or (isinstance(current.next.data, dict) and current.next.data.get('id') == key):
                current.next = current.next.next
                self._size -= 1
                return True
            current = current.next
        return False

    def search(self, key):
        current = self.head
        index = 0
        while current:
            if current.data == key or (isinstance(current.data, dict) and current.data.get('id') == key):
                return (index, current.data)
            current = current.next
            index += 1
        return None

    def traverse(self):
        elements = []
        current = self.head
        while current:
            elements.append(current.data['id'])
            current = current.next
        elements.append("NULL")
        print(" -> ".join(elements))

    # def to_list(self):
    #     nodes = []
    #     current = self.head
    #     idx = 0
    #     while current:
    #         nodes.append({"index": idx, "data": current.data['id']})
    #         current = current.next
    #         idx += 1
    #     return nodes

    def clear(self):
        self.head = None
        self._size = 0


# ==============================================================================
# 2. STACK DATA STRUCTURE (LIFO - Last In, First Out)
# ==============================================================================
class LinkedStack:
    """
    Linked list based Stack implementation (LIFO).
    Used for audit trails, activity logging, and expression processing.
    """

    def __init__(self):
        self.top = None
        self._size = 0

    def is_empty(self):
        return self.top is None

    def size(self):
        return self._size

    def get_size(self):
        return self._size

    def push(self, item):
        """Push an item onto the top of the stack. O(1) time complexity."""
        new_node = Node(item)
        new_node.next = self.top
        self.top = new_node
        self._size += 1

    def pop(self):
        """Pop and return the top item from the stack. O(1) time complexity."""
        if self.is_empty():
            raise StackUnderflowError("Cannot pop from an empty stack.")
        item = self.top.data
        self.top = self.top.next
        self._size -= 1
        return item

    def peek(self):
        """Return the top item without removing it. O(1) time complexity."""
        if self.is_empty():
            return None
        return self.top.data

    def to_list(self):
        """Traverse stack from top to bottom."""
        items = []
        current = self.top
        while current:
            items.append(current.data)
            current = current.next
        return items

    def traverse(self):
        return self.to_list()

    def clear(self):
        self.top = None
        self._size = 0


# ==============================================================================
# 3. QUEUE DATA STRUCTURE (FIFO - First In, First Out)
# ==============================================================================
class LinkedQueue:
    """
    Linked list based Queue implementation (FIFO).
    Used for citizen complaint dispatch and investigative triaging.
    """

    def __init__(self):
        self.front = None
        self.rear = None
        self._size = 0

    def is_empty(self):
        return self.front is None

    def size(self):
        return self._size

    def get_size(self):
        return self._size

    def enqueue(self, item):
        """Add an item to the rear of the queue. O(1) time complexity."""
        new_node = Node(item)
        if not self.rear:
            self.front = new_node
            self.rear = new_node
        else:
            self.rear.next = new_node
            self.rear = new_node
        self._size += 1

    def dequeue(self):
        """Remove and return the front item from the queue. O(1) time complexity."""
        if self.is_empty():
            raise QueueUnderflowError("Cannot dequeue from an empty queue.")
        item = self.front.data
        self.front = self.front.next
        if not self.front:
            self.rear = None
        self._size -= 1
        return item

    def peek(self):
        """Return the front item without removing it. O(1) time complexity."""
        if self.is_empty():
            return None
        return self.front.data

    def to_list(self):
        """Traverse queue from front to rear."""
        items = []
        current = self.front
        while current:
            items.append(current.data)
            current = current.next
        return items

    def traverse(self):
        return self.to_list()

    def clear(self):
        self.front = None
        self.rear = None
        self._size = 0


# Alias for backward compatibility
Queue = LinkedQueue


# ==============================================================================
# 4. EXPRESSION HANDLER (Infix to Postfix & Evaluation)
# ==============================================================================
class ExpressionHandler:
    """
    Parses and evaluates arithmetic / penalty expressions using LinkedStack.
    Converts Infix notation to Postfix (Reverse Polish Notation) and computes results.
    """
    OPERATORS = {'+': 1, '-': 1, '*': 2, '/': 2, '^': 3}

    @staticmethod
    def tokenize(expr):
        return re.findall(r'\d+(?:\.\d+)?|[a-zA-Z_]\w*|[+\-*/^()]', str(expr))

    @classmethod
    def infix_to_postfix(cls, expr):
        tokens = cls.tokenize(expr)
        stack = LinkedStack()
        postfix = []
        infix_trace = []

        for token in tokens:
            if re.match(r'^-?\d+(?:\.\d+)?$', token):
                postfix.append(token)
            elif token == '(':
                stack.push(token)
            elif token == ')':
                while not stack.is_empty() and stack.peek() != '(':
                    postfix.append(stack.pop())
                if not stack.is_empty():
                    stack.pop()
            elif token in cls.OPERATORS:
                while (not stack.is_empty() and stack.peek() != '(' and 
                       stack.peek() in cls.OPERATORS and 
                       cls.OPERATORS[stack.peek()] >= cls.OPERATORS[token]):
                    postfix.append(stack.pop())
                stack.push(token)
            else:
                postfix.append(token)

            infix_trace.append({
                "token": token,
                "stack": stack.to_list(),
                "output": list(postfix)
            })

        while not stack.is_empty():
            postfix.append(stack.pop())

        return postfix, infix_trace

    @classmethod
    def evaluate_postfix(cls, tokens):
        stack = LinkedStack()
        eval_trace = []
        step = 1

        for token in tokens:
            if re.match(r'^-?\d+(?:\.\d+)?$', str(token)):
                stack.push(float(token) if '.' in str(token) else int(token))
            elif token in cls.OPERATORS:
                b = stack.pop()
                a = stack.pop()
                res = 0
                if token == '+':
                    res = a + b
                elif token == '-':
                    res = a - b
                elif token == '*':
                    res = a * b
                elif token == '/':
                    res = a / b if b != 0 else 0
                elif token == '^':
                    res = a ** b

                res_formatted = int(res) if isinstance(res, float) and res.is_integer() else res
                stack.push(res_formatted)
                eval_trace.append({
                    "step": step,
                    "operation": f"{a} {token} {b} = {res_formatted}"
                })
                step += 1

        final_result = stack.pop() if not stack.is_empty() else 0
        return final_result, eval_trace


# ==============================================================================
# 5. EFFICIENCY ENGINE (Benchmarking Iterative vs Recursive)
# ==============================================================================
class EfficiencyEngine:
    """Compares Iterative vs Recursive algorithmic performance and complexities."""

    @staticmethod
    def iterative_binary_search(arr, target):
        low, high, steps = 0, len(arr) - 1, 0
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
    def recursive_binary_search(arr, target, low=0, high=None, steps=0):
        if high is None:
            high = len(arr) - 1
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

    binary_search_iter = iterative_binary_search
    binary_search_rec = recursive_binary_search

    @staticmethod
    def iterative_factorial(n):
        result, steps = 1, 0
        for i in range(2, n + 1):
            steps += 1
            result *= i
        return result, max(1, steps)

    @staticmethod
    def recursive_factorial(n, steps=0):
        steps += 1
        if n <= 1:
            return 1, steps
        sub, final_steps = EfficiencyEngine.recursive_factorial(n - 1, steps)
        return n * sub, final_steps

    factorial_iter = iterative_factorial
    factorial_rec = recursive_factorial

    @staticmethod
    def iterative_fibonacci(n):
        if n <= 0:
            return 0, 1
        if n == 1:
            return 1, 1
        a, b, steps = 0, 1, 0
        for _ in range(2, n + 1):
            steps += 1
            a, b = b, a + b
        return b, steps

    @staticmethod
    def recursive_fibonacci(n, steps_container=None):
        if steps_container is None:
            steps_container = [0]
        steps_container[0] += 1
        if n <= 0:
            return 0, steps_container[0]
        if n == 1:
            return 1, steps_container[0]
        v1, _ = EfficiencyEngine.recursive_fibonacci(n - 1, steps_container)
        v2, _ = EfficiencyEngine.recursive_fibonacci(n - 2, steps_container)
        return v1 + v2, steps_container[0]

    fibonacci_iter = iterative_fibonacci
    fibonacci_rec = recursive_fibonacci

    @classmethod
    def run_benchmark(cls, algo, n=100):
        result = {"algorithm": algo, "input": n, "iterative": {}, "recursive": {}, "analysis": {}}

        if algo == "binary_search":
            arr = list(range(1, n + 1))
            target = n // 2
            t0 = time.perf_counter_ns()
            vi, si = cls.iterative_binary_search(arr, target)
            ti = (time.perf_counter_ns() - t0) / 1000
            t0 = time.perf_counter_ns()
            vr, sr = cls.recursive_binary_search(arr, target, 0, len(arr) - 1)
            tr = (time.perf_counter_ns() - t0) / 1000
            result["iterative"] = {
                "value": vi,
                "steps": si,
                "time": round(ti, 3),
                "time_complexity": "O(log N)",
                "space_complexity": "O(1)"
            }
            result["recursive"] = {
                "value": vr,
                "steps": sr,
                "time": round(tr, 3),
                "time_complexity": "O(log N)",
                "space_complexity": "O(log N)"
            }
            result["analysis"] = {
                "winner": "Iterative",
                "reason": f"Iterative: O(1) space, Recursive: {sr} call stack frames"
            }

        elif algo == "factorial":
            n = min(n, 20)
            t0 = time.perf_counter_ns()
            vi, si = cls.iterative_factorial(n)
            ti = (time.perf_counter_ns() - t0) / 1000
            t0 = time.perf_counter_ns()
            vr, sr = cls.recursive_factorial(n)
            tr = (time.perf_counter_ns() - t0) / 1000
            result["iterative"] = {
                "value": vi,
                "steps": si,
                "time": round(ti, 3),
                "time_complexity": "O(N)",
                "space_complexity": "O(1)"
            }
            result["recursive"] = {
                "value": vr,
                "steps": sr,
                "time": round(tr, 3),
                "time_complexity": "O(N)",
                "space_complexity": "O(N)"
            }
            result["analysis"] = {
                "winner": "Iterative",
                "reason": f"Iterative: O(1) space, Recursive: {sr} stack frames"
            }

        elif algo == "fibonacci":
            n = min(n, 25)
            t0 = time.perf_counter_ns()
            vi, si = cls.iterative_fibonacci(n)
            ti = (time.perf_counter_ns() - t0) / 1000
            t0 = time.perf_counter_ns()
            vr, sr = cls.recursive_fibonacci(n)
            tr = (time.perf_counter_ns() - t0) / 1000
            result["iterative"] = {
                "value": vi,
                "steps": si,
                "time": round(ti, 3),
                "time_complexity": "O(N)",
                "space_complexity": "O(1)"
            }
            result["recursive"] = {
                "value": vr,
                "steps": sr,
                "time": round(tr, 3),
                "time_complexity": "O(2^N)",
                "space_complexity": "O(N)"
            }
            result["analysis"] = {
                "winner": "Iterative",
                "reason": f"Iterative: {si} steps O(N), Recursive: {sr} calls O(2^N)"
            }

        return result


# ==============================================================================
# DEMO EXECUTION
# ==============================================================================
def run_demo():
    print("\n" + "="*60)
    print("CCMS DSA - PHASE 1 DEMO")
    print("="*60)

    # 1. Dataset
    print("\n[1] DATASET:")
    print(f"Numeric: {SAMPLE_NUMERIC_DATASET}")
    print(f"Complaints: {len(SAMPLE_COMPLAINT_RECORDS)} items")
    print(f"Complaint Data is : {SAMPLE_COMPLAINT_RECORDS}")

    # 2. Linked List
    print("\n[2] LINKED LIST:")
    ll = SinglyLinkedList()
    for rec in SAMPLE_COMPLAINT_RECORDS:
        ll.insert_at_tail(rec)
    print(f"Inserted {ll.get_size()} records")
    print("Traverse Linked List")
    ll.traverse()
    print("============================================================")
    found = ll.search("CCMS-2026-103")
    print(f"Search result: {"Found Complaint 'CCMS-2026-103'" if found else 'Not found'}")
    ll.delete_by_value("CCMS-2026-103")
    print(f"After deleting 'CCMS-2026-103' from linked list :")
    ll.traverse()

    

    # 3. Stack (LIFO)
    print("\n[3] STACK (LIFO):")
    s = LinkedStack()
    for item in ["Event-1", "Event-2", "Event-3"]:
        s.push(item)
    print(f"Pushed to stack: Event-1, Event-2, Event-3 (Size: {s.size()})")
    print(f"Stack peek: {s.peek()}")
    print(f"Stack pop: {s.pop()}")

    # 4. Queue (FIFO)
    print("\n[4] QUEUE (FIFO):")
    q = LinkedQueue()
    for item in ["Event-1", "Event-2", "Event-3"]:
        q.enqueue(item)
    print(f"Enqueued to queue: Event-1, Event-2, Event-3 (Size: {q.size()})")
    print(f"Queue peek: {q.peek()}")
    print(f"Queue dequeue: {q.dequeue()}")
    print(f"After dequeueing Queue size: {q.size()}")
    print(f"After dequeueing first element: {q.peek()}")
    q.enqueue("Event-4")
    print(f"After enqueueing Queue size: {q.size()}")
    print(f"After enqueueing first element: {q.peek()}")

    # 5. Expression Handler
    print("\n[5] EXPRESSION HANDLING:")
    expr = "(5000*2)+(15*100)-500"
    postfix, _ = ExpressionHandler.infix_to_postfix(expr)
    result, _ = ExpressionHandler.evaluate_postfix(postfix)
    print(f"Infix: {expr}")
    print(f"Postfix: {' '.join(postfix)}")
    print(f"Result: {result}")

    # 6. Efficiency
    print("\n[6] EFFICIENCY:")
    bench = EfficiencyEngine.run_benchmark("factorial", 15)
    print(f"Algorithm: {bench['algorithm']}")
    print(f"Iterative: {bench['iterative']}")
    print(f"Analysis: {bench['analysis']['reason']}")

    print("\n" + "="*60 + "\n")


if __name__ == "__main__":
    run_demo()
