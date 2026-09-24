"""
CCMS DSA Core Engine
====================
Complete Data Structures & Algorithms implementation covering Phase 1 and Phase 2:

PHASE 1: Core Data Handling with Linear Structures
1. Dataset definitions (numeric, categorical, structured complaint records)
2. Singly Linked List with full CRUD, search, and traversal operations
3. Stack (LIFO) and Queue (FIFO) node-based implementations
4. ExpressionHandler: Stack-based Infix-to-Postfix conversion and RPN evaluation
5. EfficiencyEngine: Benchmarking Iterative vs Recursive algorithms (Time & Space complexity)

PHASE 2: Structured Data Representation
1. BinaryTree: Hierarchical tree for Vigilance Directorate Chain of Command
2. Basic Tree Traversals: Inorder, Preorder, Postorder, and Level-Order (BFS)
3. BinarySearchTree (BST): Efficient keyed data storage, search, insert, delete, and sorted retrieval
4. Graph Representation: Jurisdictional Escalation Network using Adjacency List
5. Graph Traversals: Minimal and clean Breadth-First Search (BFS) and Depth-First Search (DFS)
"""
import time
import re

# ==============================================================================
# PHASE 1 - PART 1: DATASET DEFINITIONS
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
        "title": "Demand 1000₹ for Building Permit",
        "sector": "Municipality & Public Works",
        "severity": "High",
        "status": "Under Investigation",
        "risk_score": 85,
        "timestamp": "2026-09-01 09:15"
    },
    {
        "id": "CCMS-2026-1024",
        "title": "Procurement Tender Bribery in Medical Supplies",
        "sector": "Healthcare & Supplies",
        "severity": "Critical",
        "status": "Pending Verification",
        "risk_score": 95,
        "timestamp": "2026-09-01 10:30"
    },
    {
        "id": "CCMS-2026-1038",
        "title": "Unauthorized Commercial Building Kickback",
        "sector": "Land Registration & Revenue",
        "severity": "Medium",
        "status": "Assigned",
        "risk_score": 60,
        "timestamp": "2026-09-01 11:45"
    },
    {
        "id": "CCMS-2026-1049",
        "title": "Embezzlement of Public School Renovation Funds",
        "sector": "Education & Grants",
        "severity": "High",
        "status": "Resolved",
        "risk_score": 78,
        "timestamp": "2026-09-01 14:20"
    }
]


# ==============================================================================
# CUSTOM EXCEPTIONS
# ==============================================================================
class StackUnderflowError(Exception):
    """Raised when an operation is attempted on an empty stack."""
    pass


class QueueUnderflowError(Exception):
    """Raised when an operation is attempted on an empty queue."""
    pass


# ==============================================================================
# PHASE 1 - PART 2: SINGLY LINKED LIST
# ==============================================================================
class Node:
    """Singly Linked Node used in LinkedList, Stack, and Queue structures."""
    def __init__(self, data):
        self.data = data
        self.next = None


class SinglyLinkedList:

    def __init__(self):
        self.head = None
        self._size = 0

    def is_empty(self):
        return self.head is None

    def get_size(self):
        return self._size

    def size(self):
        return self._size

# =======================Insert Operations====================
    def insert_at_head(self, data):
        """Insert a new node at the beginning of the list. O(1) Time."""
        new_node = Node(data)
        new_node.next = self.head
        self.head = new_node

    def insert_at_tail(self, data):
        """Insert a new node at the end of the list. O(N) Time."""
        new_node = Node(data)
        if self.head is None:
            self.head = new_node
        else:
            current = self.head
            while current.next:
                current = current.next
            current.next = new_node

    def insert_at_index(self, index, data):
        """Insert a new node at a specific index. O(N) Time."""
        if self.head is None:
            self.insert_at_head(data)
            return
        new_node = Node(data)
        current = self.head
        i = 0
        while i < index-1:
            current = current.next
            i += 1
        new_node.next = current.next
        current.next = new_node
        
# =======================Delete Operations====================
    def delete_at_head(self):
        """Delete the head node and return its data. O(1) Time."""
        if self.head is None:
            return None
        deleted_data = self.head.data
        self.head = self.head.next
        self._size -= 1
        return deleted_data
    
    def delete_at_tail(self):
        """Delete the tail node and return its data. O(N) Time."""
        if self.head is None:
            return None
        if self.head.next is None:
            deleted_data = self.head.data
            self.head = None
            self._size -= 1
            return deleted_data
        current = self.head
        while current.next.next:
            current = current.next
        deleted_data = current.next.data
        current.next = None
        self._size -= 1
        return deleted_data

    def delete_at_index(self, index):
        """Delete node at given index and return its data. O(N) Time."""
        if index < 0 or index >= self._size or self.head is None:
            return None
        if index == 0:
            return self.delete_at_head()
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

    def delete_by_value(self, key):
        """Delete first node matching key/id. Returns True if deleted, else False. O(N) Time."""
        if self.head is None:
            return False

        if self._matches(self.head.data, key):
            self.head = self.head.next
            self._size -= 1
            return True

        current = self.head
        while current.next:
            if self._matches(current.next.data, key):
                current.next = current.next.next
                self._size -= 1
                return True
            current = current.next
        return False

    def delete_by_id(self, target_id):
        """Delete a node by matching 'id' in structured data. Returns True if deleted, else False."""
        return self.delete_by_value(target_id)
    
    # =======================Search====================

    def search(self, key):
        """Search for a node matching key/id/title. Returns (index, data) tuple or None. O(N) Time."""
        current = self.head
        index = 0
        while current:
            if self._matches(current.data, key):
                return (index, current.data)

            current = current.next
            index += 1

        return None

    def traverse(self):
        """Traverse and return list of node data, printing visually. O(N) Time."""
        elements = []
        labels = []
        current = self.head
        while current:
            elements.append(current.data)
            if isinstance(current.data, dict):
                labels.append(str(current.data.get("id", current.data.get("title", current.data))))
            else:
                labels.append(str(current.data))
            current = current.next
        labels.append("NULL")
        print(" -> ".join(labels))
        return elements

    def to_list(self):
        """Return list of node dicts with index, data, and has_next pointer. O(N) Time."""
        nodes = []
        current = self.head
        idx = 0
        while current:
            nodes.append({
                "index": idx,
                "data": current.data,
                "has_next": current.next is not None
            })
            current = current.next
            idx += 1
        return nodes

# =======================Clear Linked List ====================
    def clear(self):
        self.head = None
        self._size = 0


# ==============================================================================
# PHASE 1 - PART 3: STACK & QUEUE (LINKED-LIST BASED)
# ==============================================================================
class Stack:

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
        new_node = Node(item)
        new_node.next = self.top
        self.top = new_node
        self._size += 1

    def pop(self):
        if self.is_empty():
            raise StackUnderflowError("Cannot pop from an empty stack.")
        item = self.top.data
        self.top = self.top.next
        self._size -= 1
        return item

    def peek(self):
        if self.is_empty():
            return None
        return self.top.data

    def to_list(self):
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


class Queue:
    def __init__(self):
        self.front = None
        self.rear = None
        self._size = 0

    def is_empty(self):
        return self.front is None

    def size(self):
        return self._size

    def enqueue(self, item):
        new_node = Node(item)
        if not self.rear:
            self.front = new_node
            self.rear = new_node
        else:
            self.rear.next = new_node
            self.rear = new_node
        self._size += 1

    def dequeue(self):
        if self.is_empty():
            raise QueueUnderflowError("Cannot dequeue from an empty queue.")
        item = self.front.data
        self.front = self.front.next
        if self.front is None:
            self.rear = None
        self._size -= 1
        return item

    def peek(self):
        if self.is_empty():
            return None
        return self.front.data

    def to_list(self):
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


# ==============================================================================
# PHASE 1 - PART 4: EXPRESSION HANDLING (INFIX TO POSTFIX & EVALUATION)
# ==============================================================================
class ExpressionHandler:
    """
    Parses arithmetic and penalty formulas using Stack.
    Converts Infix notation to Postfix (RPN) and computes results step-by-step.
    """
    OPERATORS = {'+': 1, '-': 1, '*': 2, '/': 2, '^': 3}

    @staticmethod
    def tokenize(expr):
        """Tokenize arithmetic expression into numbers, operators, and parentheses."""
        return re.findall(r'\d+(?:\.\d+)?|[a-zA-Z_]\w*|[+\-*/^()]', str(expr))

    @classmethod
    def infix_to_postfix(cls, expr):
        tokens = cls.tokenize(expr)
        stack = Stack()
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
                    stack.pop()  # Discard '('
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
                "output": " ".join(postfix)
            })

        while not stack.is_empty():
            postfix.append(stack.pop())

        return postfix, infix_trace

    @classmethod
    def evaluate_postfix(cls, tokens):
        """
        Evaluate Postfix (RPN) tokens using an operand Stack.
        Returns (final_result, step_by_step_trace).
        """
        stack = Stack()
        eval_trace = []
        step = 1

        for token in tokens:
            if re.match(r'^-?\d+(?:\.\d+)?$', str(token)):
                val = float(token) if '.' in str(token) else int(token)
                stack.push(val)
                eval_trace.append({
                    "step": step,
                    "token": str(token),
                    "action": f"Push operand {val}",
                    "stack": [str(x) for x in stack.to_list()]
                })
            elif token in cls.OPERATORS:
                if stack.size() < 2:
                    continue
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

                res_formatted = int(res) if isinstance(res, float) and res.is_integer() else round(res, 2)
                stack.push(res_formatted)
                eval_trace.append({
                    "step": step,
                    "token": str(token),
                    "action": f"Compute {a} {token} {b} = {res_formatted}",
                    "stack": [str(x) for x in stack.to_list()]
                })
            step += 1

        final_result = stack.pop() if not stack.is_empty() else 0
        return final_result, eval_trace

    @classmethod
    def calculate(cls, expr):
        """Complete evaluation pipeline returning result, postfix string, and traces."""
        postfix_tokens, infix_trace = cls.infix_to_postfix(expr)
        postfix_str = " ".join(postfix_tokens)
        result, eval_trace = cls.evaluate_postfix(postfix_tokens)
        return result, postfix_str, infix_trace, eval_trace


# ==============================================================================
# PHASE 1 - PART 5: EFFICIENCY CONCEPTS (ITERATIVE VS RECURSIVE)
# ==============================================================================
class EfficiencyEngine:

    def iterative_factorial(n):
        """Iterative Factorial: O(N) Time, O(1) Space."""
        result, steps = 1, 0
        for i in range(2, n + 1):
            steps += 1
            result *= i
        return result, max(1, steps)

    def recursive_factorial(n):
        if n <= 1:
            return 1
        return n * EfficiencyEngine.recursive_factorial(n - 1)


# ==============================================================================
# PHASE 2 - PART 1 & 2: BINARY TREE & BASIC TRAVERSALS
# ==============================================================================
class BinaryTreeNode:
    """Represents a node in a hierarchical Binary Tree."""
    def __init__(self, value, data=None):
        self.value = value
        self.data = data or {}
        self.left = None
        self.right = None

    def to_dict(self):
        return {
            "value": self.value,
            "data": self.data,
            "left": self.left.to_dict() if self.left else None,
            "right": self.right.to_dict() if self.right else None
        }


class BinaryTree:
    """
    Binary Tree for hierarchical administrative command structure:
    Central Vigilance Directorate -> Regional Directorates -> Inspection Wings.
    Supports Inorder, Preorder, Postorder, and Level-Order (BFS) traversals.
    """
    def __init__(self, root_value=None, root_data=None):
        self.root = BinaryTreeNode(root_value, root_data) if root_value is not None else None

    def get_height(self, node=None):
        """Calculate the height of the tree. O(N) Time."""
        if self.root is None:
            return 0
        if node is None and node is not False:
            node = self.root

        def _height(curr):
            if curr is None:
                return 0
            return 1 + max(_height(curr.left), _height(curr.right))

        return _height(node)

    def count_nodes(self, node=None):
        """Count total nodes in tree. O(N) Time."""
        if self.root is None:
            return 0
        if node is None:
            node = self.root

        def _count(curr):
            if curr is None:
                return 0
            return 1 + _count(curr.left) + _count(curr.right)

        return _count(node)

    # 1. Inorder Traversal: Left -> Root -> Right
    def inorder_traversal(self, node=None):
        """Inorder Traversal: Left -> Root -> Right. O(N) Time."""
        if self.root is None:
            return []
        if node is None:
            node = self.root

        result = []

        def _inorder(curr):
            if curr:
                _inorder(curr.left)
                result.append(curr.value)
                _inorder(curr.right)

        _inorder(node)
        return result
    
    # 2. Preorder Traversal: Root -> Left -> Right
    def preorder_traversal(self, node=None):
        """Preorder Traversal: Root -> Left -> Right. O(N) Time."""
        if self.root is None:
            return []
        if node is None:
            node = self.root

        result = []

        def _preorder(curr):
            if curr:
                result.append(curr.value)
                _preorder(curr.left)
                _preorder(curr.right)

        _preorder(node)
        return result

    # 3. Postorder Traversal: Left -> Right -> Root
    def postorder_traversal(self, node=None):
        """Postorder Traversal: Left -> Right -> Root. O(N) Time."""
        if self.root is None:
            return []
        if node is None:
            node = self.root

        result = []

        def _postorder(curr):
            if curr:
                _postorder(curr.left)
                _postorder(curr.right)
                result.append(curr.value)

        _postorder(node)
        return result

    # 4. Level-Order Traversal (BFS using Queue)
    def level_order_traversal(self):
        """Level-Order (BFS) Traversal using Queue. O(N) Time."""
        if self.root is None:
            return []

        result = []
        queue = Queue()
        queue.enqueue(self.root)

        while not queue.is_empty():
            current = queue.dequeue()
            result.append(current.value)
            if current.left:
                queue.enqueue(current.left)
            if current.right:
                queue.enqueue(current.right)

        return result

    def to_dict(self):
        return self.root.to_dict() if self.root else None


# ==============================================================================
# PHASE 2 - PART 3: BINARY SEARCH TREE (BST)
# ==============================================================================
class BSTNode:
    """Represents a node in a Binary Search Tree keyed by a numeric score or ID."""
    def __init__(self, key, data=None):
        self.key = key
        self.data = data or {}
        self.left = None
        self.right = None

    def to_dict(self):
        return {
            "key": self.key,
            "data": self.data,
            "left": self.left.to_dict() if self.left else None,
            "right": self.right.to_dict() if self.right else None
        }


class BinarySearchTree:
    """
    Binary Search Tree (BST) for efficient indexed data storage & retrieval:
    - Stores complaints keyed by risk score / priority index.
    - Preserves BST property: Left.key < Root.key < Right.key
    - Supports insert, search, delete, min/max, and sorted inorder retrieval.
    """
    def __init__(self):
        self.root = None
        self._size = 0

    def is_empty(self):
        return self.root is None

    def size(self):
        return self._size

    def insert(self, key, data=None):
        """Insert a (key, data) pair into the BST. O(log N) avg, O(N) worst."""
        new_node = BSTNode(key, data)
        if self.root is None:
            self.root = new_node
            self._size += 1
            return True

        curr = self.root
        while True:
            if key < curr.key:
                if curr.left is None:
                    curr.left = new_node
                    self._size += 1
                    return True
                curr = curr.left
            elif key > curr.key:
                if curr.right is None:
                    curr.right = new_node
                    self._size += 1
                    return True
                curr = curr.right
            else:
                # Key exists, update data
                curr.data = data
                return False

    def search(self, key):
        """Search for a node by key. Returns BSTNode or None. O(log N) avg."""
        curr = self.root
        while curr:
            if key == curr.key:
                return curr
            elif key < curr.key:
                curr = curr.left
            else:
                curr = curr.right
        return None

    def find_min(self, node=None):
        """Find the node with the minimum key in subtree."""
        curr = node if node is not None else self.root
        if curr is None:
            return None
        while curr.left:
            curr = curr.left
        return curr

    def find_max(self, node=None):
        """Find the node with the maximum key in subtree."""
        curr = node if node is not None else self.root
        if curr is None:
            return None
        while curr.right:
            curr = curr.right
        return curr

    def delete(self, key):
        """
        Delete a node by key from BST.
        Handles: leaf node, one child, and two children (inorder successor).
        """
        deleted_flag = [False]

        def _delete_node(root, key):
            if root is None:
                return root

            if key < root.key:
                root.left = _delete_node(root.left, key)
            elif key > root.key:
                root.right = _delete_node(root.right, key)
            else:
                deleted_flag[0] = True
                # Case 1 & 2: 0 or 1 child
                if root.left is None:
                    return root.right
                elif root.right is None:
                    return root.left

                # Case 3: 2 children - get inorder successor (min in right subtree)
                successor = self.find_min(root.right)
                root.key = successor.key
                root.data = successor.data
                root.right = _delete_node(root.right, successor.key)

            return root

        self.root = _delete_node(self.root, key)
        if deleted_flag[0]:
            self._size -= 1
        return deleted_flag[0]

    def inorder_traversal(self):
        """Returns all records sorted in ascending order of keys. O(N) Time."""
        result = []

        def _inorder(curr):
            if curr:
                _inorder(curr.left)
                result.append({"key": curr.key, "data": curr.data})
                _inorder(curr.right)

        _inorder(self.root)
        return result

    def to_dict(self):
        return self.root.to_dict() if self.root else None

    
# ==============================================================================
# PHASE 2 - PART 4 & 5: GRAPH REPRESENTATION & TRAVERSALS (BFS & DFS)
# ==============================================================================
class Graph:
    """
    Graph representation of CCMS Jurisdictional Routing & Case Escalation Network:
    - Uses Adjacency List: { vertex: [neighbor1, neighbor2, ...] }
    - Supports BFS (Breadth-First Search) and DFS (Depth-First Search) traversals.
    """
    def __init__(self):
        self.adj_list = {}

    def add_vertex(self, vertex):
        """Add a vertex to the graph if not already present."""
        if vertex not in self.adj_list:
            self.adj_list[vertex] = []

    def add_edge(self, u, v, bidirectional=True):
        """Add an edge between vertex u and vertex v."""
        self.add_vertex(u)
        self.add_vertex(v)
        if v not in self.adj_list[u]:
            self.adj_list[u].append(v)
        if bidirectional and u not in self.adj_list[v]:
            self.adj_list[v].append(u)

    def get_vertices(self):
        """Return list of all vertices in the graph."""
        return list(self.adj_list.keys())

    def get_neighbors(self, vertex):
        """Return neighbors of a given vertex."""
        return self.adj_list.get(vertex, [])

    # 1. Breadth-First Search (BFS) using Queue
    def bfs(self, start_vertex):
        """
        Breadth-First Search (BFS) starting from start_vertex.
        Uses Queue (FIFO) to explore nodes level-by-level.
        Returns visited path list and step-by-step trace.
        """
        if start_vertex not in self.adj_list:
            return [], []

        visited = set()
        queue = Queue()
        traversal_order = []
        trace = []
        step = 1

        queue.enqueue(start_vertex)
        visited.add(start_vertex)

        while not queue.is_empty():
            current = queue.dequeue()
            traversal_order.append(current)

            unvisited_neighbors = []
            for neighbor in self.adj_list.get(current, []):
                if neighbor not in visited:
                    visited.add(neighbor)
                    queue.enqueue(neighbor)
                    unvisited_neighbors.append(neighbor)

            trace.append({
                "step": step,
                "current": current,
                "enqueued": unvisited_neighbors,
                "queue_state": queue.to_list()
            })
            step += 1

        return traversal_order, trace

    # 2. Depth-First Search (DFS)
    def dfs(self, start_vertex):
        """
        Depth-First Search (DFS) starting from start_vertex.
        Explores as deep as possible along each branch before backtracking.
        Returns visited path list and step-by-step trace.
        """
        if start_vertex not in self.adj_list:
            return [], []

        visited = set()
        traversal_order = []
        trace = []
        step = [1]

        def _dfs_recursive(vertex):
            visited.add(vertex)
            traversal_order.append(vertex)
            trace.append({
                "step": step[0],
                "visited": vertex,
                "path_so_far": list(traversal_order)
            })
            step[0] += 1

            for neighbor in self.adj_list.get(vertex, []):
                if neighbor not in visited:
                    _dfs_recursive(neighbor)

        _dfs_recursive(start_vertex)
        return traversal_order, trace

    def to_dict(self):
        """Return adjacency list as a dictionary."""
        return self.adj_list


# ==============================================================================
# HELPER BUILDERS & DEMO RUNNERS
# ==============================================================================

def calculate_complaint_risk_score(complaint, index=0):
    """Derives a deterministic, unique 1-100 risk score key for a complaint record."""
    if isinstance(complaint, dict) and "risk_score" in complaint and complaint["risk_score"] is not None:
        try:
            return int(complaint["risk_score"])
        except (ValueError, TypeError):
            pass

    severity = complaint.get("severity", "Medium") if isinstance(complaint, dict) else "Medium"
    base_scores = {
        "Critical": 90,
        "High": 70,
        "Medium": 45,
        "Low": 20
    }
    base = base_scores.get(severity, 50)
    
    # Generate stable offset from complaint ID or index
    cid = str(complaint.get("complaint_id", complaint.get("id", ""))) if isinstance(complaint, dict) else str(index)
    digits = "".join([c for c in cid if c.isdigit()])
    offset = (int(digits[-2:]) % 18) if len(digits) >= 2 else (index % 15)
    return min(99, max(5, base + offset))


def build_dataset_vigilance_tree(departments=None):
    """
    Builds Hierarchical Binary Tree directly from the CCMS Departments dataset.
    Root: Central Vigilance Directorate (HQ)
    Left Branch: Infrastructure & Municipal Wings
    Right Branch: Law Enforcement, Healthcare & Public Services
    """
    tree = BinaryTree("Central Vigilance Directorate (HQ)", {
        "role": "Super Admin Command Center",
        "jurisdiction": "National Integrity Oversight",
        "total_cases": sum([d.get("total_cases", 0) for d in departments]) if departments else 194
    })

    if not departments:
        return build_default_vigilance_tree()

    # Split departments into left & right branches
    left_depts = [d for d in departments if any(k in d.get("name", "").lower() for k in ["public", "works", "transport", "municipality", "pwd", "trn"])]
    right_depts = [d for d in departments if d not in left_depts]

    if not left_depts and not right_depts:
        left_depts = departments[:len(departments)//2]
        right_depts = departments[len(departments)//2:]

    # Left Root Branch
    left_lead = left_depts[0] if left_depts else {"name": "Directorate of Public Infrastructure", "head": "Joint Director PWD", "risk_level": "High"}
    tree.root.left = BinaryTreeNode(left_lead.get("name", "Directorate of Public Infrastructure"), {
        "dept_id": left_lead.get("dept_id", "DEPT-PWD"),
        "role": left_lead.get("head", "Joint Director PWD"),
        "risk_level": left_lead.get("risk_level", "High"),
        "total_cases": left_lead.get("total_cases", 0)
    })

    # Left children
    if len(left_depts) > 1:
        d1 = left_depts[1]
        tree.root.left.left = BinaryTreeNode(d1.get("name", "Civil Works Bureau"), {
            "dept_id": d1.get("dept_id", ""),
            "role": d1.get("head", "Zonal Inspector"),
            "risk_level": d1.get("risk_level", "High"),
            "total_cases": d1.get("total_cases", 0)
        })
    if len(left_depts) > 2:
        d2 = left_depts[2]
        tree.root.left.right = BinaryTreeNode(d2.get("name", "Procurement Audit Wing"), {
            "dept_id": d2.get("dept_id", ""),
            "role": d2.get("head", "Chief Auditor"),
            "risk_level": d2.get("risk_level", "Medium"),
            "total_cases": d2.get("total_cases", 0)
        })

    # Right Root Branch
    right_lead = right_depts[0] if right_depts else {"name": "Directorate of Law & Public Services", "head": "Joint Director Police", "risk_level": "High"}
    tree.root.right = BinaryTreeNode(right_lead.get("name", "Directorate of Law & Public Services"), {
        "dept_id": right_lead.get("dept_id", "DEPT-POL"),
        "role": right_lead.get("head", "Superintendent of Police"),
        "risk_level": right_lead.get("risk_level", "High"),
        "total_cases": right_lead.get("total_cases", 0)
    })

    # Right children
    if len(right_depts) > 1:
        d3 = right_depts[1]
        tree.root.right.left = BinaryTreeNode(d3.get("name", "Healthcare Oversight Wing"), {
            "dept_id": d3.get("dept_id", ""),
            "role": d3.get("head", "Chief Medical Inspector"),
            "risk_level": d3.get("risk_level", "Medium"),
            "total_cases": d3.get("total_cases", 0)
        })
    if len(right_depts) > 2:
        d4 = right_depts[2]
        tree.root.right.right = BinaryTreeNode(d4.get("name", "Education & Grants Wing"), {
            "dept_id": d4.get("dept_id", ""),
            "role": d4.get("head", "Deputy Commissioner"),
            "risk_level": d4.get("risk_level", "Low"),
            "total_cases": d4.get("total_cases", 0)
        })

    return tree


def build_dataset_complaints_bst(complaints=None):
    """
    Builds Binary Search Tree (BST) directly from the CCMS Complaints dataset.
    Organizes cases keyed by Risk Score (1-100).
    """
    bst = BinarySearchTree()
    if not complaints:
        for rec in SAMPLE_COMPLAINT_RECORDS:
            bst.insert(rec["risk_score"], rec)
        return bst

    used_keys = set()
    for idx, c in enumerate(complaints):
        base_key = calculate_complaint_risk_score(c, idx)
        key = base_key
        # Ensure unique key for distinct complaint records in BST
        while key in used_keys:
            key += 1
        used_keys.add(key)

        data = {
            "id": c.get("complaint_id", c.get("id")),
            "title": c.get("complaint_title", c.get("title", "Corruption Complaint")),
            "sector": c.get("sector", c.get("misconduct_category", "Public Governance")),
            "severity": c.get("severity", "Medium"),
            "status": c.get("complaint_status", c.get("status", "Pending")),
            "risk_score": key,
            "location": c.get("location", "Central Zone"),
            "created_at": str(c.get("created_at", ""))
        }
        bst.insert(key, data)

    return bst


def build_dataset_escalation_graph(departments=None):
    """
    Builds Escalation & Jurisdictional Network Graph using CCMS Dataset Departments & Hubs.
    """
    g = Graph()
    g.add_edge("Citizen Portal Intake", "Central Triage Desk")
    
    dept_names = [d.get("name") for d in departments] if departments else [
        "Police & Law Enforcement", "Municipality & Public Works", "Healthcare & Supplies",
        "Education & Grants", "Transport & Licensing"
    ]

    for dept in dept_names:
        g.add_edge("Central Triage Desk", dept)
        g.add_edge(dept, "Field & Forensic Investigation Unit")

    g.add_edge("Field & Forensic Investigation Unit", "Central Vigilance Directorate")
    g.add_edge("Central Vigilance Directorate", "Legal Prosecution & Disciplinary Tribunal")
    return g


def build_corruption_category_tree():
    """
    Constructs the Binary Tree for Complaint Category Classification:
                     CORRUPTION
                    /          \
               BRIBERY        FRAUD
               /     \        /    \
           DEMAND   ACCEPT FINANCIAL DOCUMENT
    """
    root = BinaryTreeNode("CORRUPTION", {
        "code": "CAT-ROOT",
        "level": 0,
        "category_type": "Root Classification",
        "icon": "fa-shield-halved",
        "severity": "Systemic",
        "dept": "Central Vigilance Directorate (HQ)",
        "description": "Master classification taxonomy covering all forms of public corruption and official misconduct."
    })
    
    # Left Branch: BRIBERY
    root.left = BinaryTreeNode("BRIBERY", {
        "code": "CAT-BRB",
        "level": 1,
        "category_type": "Primary Misconduct Wing",
        "icon": "fa-hand-holding-dollar",
        "severity": "Critical",
        "dept": "Police, Transport & Land Revenue",
        "description": "Corrupt exchange, solicitation, or reception of illegal financial gratification for official acts."
    })
    
    # Left -> Left: DEMAND
    root.left.left = BinaryTreeNode("DEMAND", {
        "code": "CAT-BRB-DEM",
        "level": 2,
        "category_type": "Actionable Leaf Category",
        "icon": "fa-gavel",
        "severity": "Critical",
        "dept": "Anti-Extortion & Police Oversight Wing",
        "description": "Active solicitation, coercion, or extortion of bribes/kickbacks from citizens prior to service delivery."
    })
    
    # Left -> Right: ACCEPT
    root.left.right = BinaryTreeNode("ACCEPT", {
        "code": "CAT-BRB-ACC",
        "level": 2,
        "category_type": "Actionable Leaf Category",
        "icon": "fa-money-bill-transfer",
        "severity": "High",
        "dept": "Central Triage & Verification Desk",
        "description": "Voluntary receipt or taking of illicit kickbacks, speed money, or covert gifts by a public officer."
    })
    
    # Right Branch: FRAUD
    root.right = BinaryTreeNode("FRAUD", {
        "code": "CAT-FRD",
        "level": 1,
        "category_type": "Primary Misconduct Wing",
        "icon": "fa-file-invoice-dollar",
        "severity": "Critical",
        "dept": "Public Works & Municipal Corporation",
        "description": "Intentional deception, embezzlement, or falsification resulting in wrongful loss to the public treasury."
    })
    
    # Right -> Left: FINANCIAL
    root.right.left = BinaryTreeNode("FINANCIAL", {
        "code": "CAT-FRD-FIN",
        "level": 2,
        "category_type": "Actionable Leaf Category",
        "icon": "fa-sack-dollar",
        "severity": "Critical",
        "dept": "Public Procurement Audit Cell",
        "description": "Treasury fund embezzlement, procurement tender rigging, ghost beneficiary billing, and siphon schemes."
    })
    
    # Right -> Right: DOCUMENT
    root.right.right = BinaryTreeNode("DOCUMENT", {
        "code": "CAT-FRD-DOC",
        "level": 2,
        "category_type": "Actionable Leaf Category",
        "icon": "fa-file-signature",
        "severity": "High",
        "dept": "Land Records Intelligence Unit",
        "description": "Forgery of official certificates, title deeds, falsified audit registers, and identity manipulation."
    })
    
    tree = BinaryTree()
    tree.root = root
    return tree


def build_default_vigilance_tree():
    """Build pre-seeded Departmental Hierarchy Binary Tree."""
    tree = BinaryTree("Central Vigilance Directorate (HQ)", {"role": "Chief Commissioner"})
    tree.root.left = BinaryTreeNode("Directorate of Public Works", {"role": "Joint Director PWD"})
    tree.root.right = BinaryTreeNode("Directorate of Revenue & Police", {"role": "Joint Director Revenue"})

    tree.root.left.left = BinaryTreeNode("Civil Works Inspection Bureau", {"role": "Zonal Inspector"})
    tree.root.left.right = BinaryTreeNode("Procurement Audit Cell", {"role": "Chief Auditor"})

    tree.root.right.left = BinaryTreeNode("Anti-Extortion Police Wing", {"role": "Superintendent"})
    tree.root.right.right = BinaryTreeNode("Land Records Intelligence", {"role": "Deputy Commissioner"})
    return tree


def build_default_complaints_bst():
    """Build pre-seeded Complaints Binary Search Tree indexed by Risk Score."""
    bst = BinarySearchTree()
    for rec in SAMPLE_COMPLAINT_RECORDS:
        bst.insert(rec["risk_score"], rec)
    return bst


def build_default_escalation_graph():
    """Build pre-seeded Escalation Network Graph."""
    g = Graph()
    g.add_edge("Citizen Front Desk", "Triage & Verification Desk")
    g.add_edge("Triage & Verification Desk", "Special Investigation Bureau")
    g.add_edge("Triage & Verification Desk", "Forensic Audit Cell")
    g.add_edge("Special Investigation Bureau", "Field Inspection Unit")
    g.add_edge("Special Investigation Bureau", "Legal Prosecution Wing")
    g.add_edge("Forensic Audit Cell", "Central Vigilance Directorate")
    g.add_edge("Legal Prosecution Wing", "Central Vigilance Directorate")
    g.add_edge("Central Vigilance Directorate", "Disciplinary Tribunal")
    return g


def run_phase1_demo():
    print("\n" + "="*65)
    print("CCMS DSA - PHASE 1: CORE DATA HANDLING WITH LINEAR STRUCTURES")
    print("="*65)

    # 1. Dataset Input
    print("\n[1] DATASET INPUT:")
    print(f"  • Numeric Dataset: {SAMPLE_NUMERIC_DATASET}")
    print(f"  • Sectors Dataset: {SAMPLE_SECTORS_DATASET[:3]}... ({len(SAMPLE_SECTORS_DATASET)} sectors)")
    print(f"  • Complaint Records: {len(SAMPLE_COMPLAINT_RECORDS)} items")

    # 2. Linked List
    print("\n[2] SINGLY LINKED LIST:")
    ll = SinglyLinkedList()
    for rec in SAMPLE_COMPLAINT_RECORDS:
        ll.insert_at_tail(rec)
    print(f"  • Inserted {ll.get_size()} records at tail.")
    print("  • Traversal Output:")
    print("    ", end="")
    ll.traverse()
    found = ll.search("CCMS-2026-1038")
    if found:
        print(f"  • Search 'CCMS-2026-1038': Index {found[0]} -> {found[1]['title']}")
    else:
        print("  • Search 'CCMS-2026-1038': Not found")
    ll.delete_by_value("CCMS-2026-1038")
    print("  • After deleting 'CCMS-2026-1038':")
    print("    ", end="")
    ll.traverse()

    # 3. Stack
    print("\n[3] STACK (LIFO):")
    stack = Stack()
    for item in ["Event-1: Case Logged", "Event-2: Evidence Uploaded", "Event-3: Officer Assigned"]:
        stack.push(item)
    print(f"  • Stack Size: {stack.size()} | Peek: {stack.peek()}")
    print(f"  • Stack Pop (LIFO): {stack.pop()}")

    # 3.Queue
    print("\n[3] QUEUE (FIFO):")
    queue = Queue()
    for item in ["Dispatch-A", "Dispatch-B", "Dispatch-C"]:
        queue.enqueue(item)
    print(f"  • Queue Size: {queue.size()} | Peek: {queue.peek()}")
    print(f"  • Queue Dequeue (FIFO): {queue.dequeue()}")

    # 4. Expression Handling
    print("\n[4] EXPRESSION HANDLING (INFIX TO POSTFIX & EVALUATION):")
    expr = "( 5000 * 2 ) + ( 15 * 100 ) - 500"
    res, postfix, _, _ = ExpressionHandler.calculate(expr)
    print(f"  • Infix:   {expr}")
    print(f"  • Postfix: {postfix}")
    print(f"  • Result:  {res}")

    # 5. Efficiency Engine
    print("\n[5] EFFICIENCY ENGINE (ITERATIVE VS RECURSIVE BENCHMARK):")
    bench = EfficiencyEngine.run_benchmark("factorial", 10)
    print(f"  • Algorithm: Factorial (N=10)")
    print(f"  • Iterative: {bench['iterative']['time_us']} µs | {bench['iterative']['steps']} steps | {bench['iterative']['space_complexity']}")
    print(f"  • Recursive: {bench['recursive']['time_us']} µs | {bench['recursive']['steps']} calls | {bench['recursive']['space_complexity']}")
    print(f"  • Verdict:   {bench['analysis']['winner']} ({bench['analysis']['explanation']})")


def run_phase2_demo():
    print("\n" + "="*65)
    print("CCMS DSA - PHASE 2: STRUCTURED DATA REPRESENTATION")
    print("="*65)

    # 1. Binary Tree
    print("\n[1] BINARY TREE (HIERARCHICAL COMMAND STRUCTURE):")
    tree = build_default_vigilance_tree()
    print(f"  • Root Node: {tree.root.value}")
    print(f"  • Tree Height: {tree.get_height()} levels | Total Nodes: {tree.count_nodes()}")

    # 2. Tree Traversals
    print("\n[2] BASIC TREE TRAVERSALS:")
    print(f"  • Inorder   (Left -> Root -> Right): {tree.inorder_traversal()[:3]}...")
    print(f"  • Preorder  (Root -> Left -> Right): {tree.preorder_traversal()[:3]}...")
    print(f"  • Postorder (Left -> Right -> Root): {tree.postorder_traversal()[:3]}...")
    print(f"  • Level-Order BFS (Queue-based):     {tree.level_order_traversal()[:3]}...")

    # 3. Binary Search Tree (BST)
    print("\n[3] BINARY SEARCH TREE (BST CASE RISK INDEX):")
    bst = build_default_complaints_bst()
    print(f"  • Stored {bst.size()} cases in BST sorted by Risk Score.")
    print(f"  • Min Risk Case: Score {bst.find_min().key}")
    print(f"  • Max Risk Case: Score {bst.find_max().key}")
    search_node = bst.search(85)
    print(f"  • Search Risk Score 85: Found -> {search_node.data['title']}")
    sorted_cases = bst.inorder_traversal()
    print(f"  • Sorted Inorder Keys: {[item['key'] for item in sorted_cases]}")

    # 4. Graph Representation
    print("\n[4] GRAPH REPRESENTATION (ADJACENCY LIST):")
    g = build_default_escalation_graph()
    vertices = g.get_vertices()
    print(f"  • Total Escalation Hubs: {len(vertices)}")
    for v in vertices[:3]:
        print(f"    - {v} -> {g.get_neighbors(v)}")

    # 5. Graph Traversals (BFS & DFS)
    print("\n[5] GRAPH TRAVERSALS (BFS & DFS):")
    start_node = "Citizen Front Desk"
    bfs_path, _ = g.bfs(start_node)
    dfs_path, _ = g.dfs(start_node)
    print(f"  • BFS Route (Level-by-Level):  {' -> '.join(bfs_path)}")
    print(f"  • DFS Route (Deep-Path First): {' -> '.join(dfs_path)}")

    print("\n" + "="*65 + "\n")


if __name__ == "__main__":
    run_phase1_demo()
    run_phase2_demo()
