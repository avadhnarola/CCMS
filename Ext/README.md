# CCMS - Corruption Complaint Management System

A full-stack, zero-dependency Anti-Corruption & Vigilance Command Portal powered by Python and Data Structures & Algorithms (DSA).

---

## Quick Start (Zero External Backend Setup)

No MySQL, XAMPP, or PHP server is required. The project includes a self-contained local database pre-seeded with rich static datasets.

### 1. Install Dependencies
```bash
pip install -r requirements.txt
```

### 2. Run the Application
```bash
python app.py
```
Open your browser at **`http://127.0.0.1:5000`**

---

## Default Access Credentials

| Portal | Email | Password | Role |
|---|---|---|---|
| **Admin Command Center** | `admin@ccms.gov.in.gov.in` | `admin123` | Super Admin (Access DSA Lab, Analytics, Officer/Dept Management) |
| **Officer Portal** | `officer@test.com` | `officer123` | Senior Vigilance Inspector |
| **Citizen Whistleblower** | `citizen@test.com` | `citizen123` | Whistleblower Citizen |

---

## DSA Implementation Details

### PHASE 1: Core Data Handling with Linear Structures (`dsa.py`)
1. **Dataset Input**: Defined datasets for numeric data, vigilance sectors, and complaint records.
2. **Singly Linked List (`SinglyLinkedList`)**: Dynamic sequential node-pointer storage supporting:
   - `insert_at_head()`, `insert_at_tail()`
   - `delete_by_value()`, `delete_at_index()`
   - `search()`, `traverse()`, `to_list()`
3. **Stack & Queue**:
   - `Stack`: LIFO node-based stack for audit trails and expression evaluation (`push`, `pop`, `peek`).
   - `Queue`: FIFO node-based queue for complaint dispatch and BFS (`enqueue`, `dequeue`, `peek`).
4. **Stack Expression Handling (`ExpressionHandler`)**:
   - Infix to Postfix (RPN) conversion using `Stack`.
   - Postfix evaluation with step-by-step operand transition trace.
5. **Efficiency Engine (`EfficiencyEngine`)**:
   - Iterative vs. Recursive comparisons for Binary Search, Factorial, and Fibonacci.
   - Live Big-O Time & Auxiliary Space Complexity benchmark.

---

### PHASE 2: Structured Data Representation (`dsa.py`)
1. **Hierarchical Binary Tree (`BinaryTree`)**:
   - Departmental & Vigilance Directorate Chain of Command.
2. **Basic Tree Traversals**:
   - **Inorder**: Left $\rightarrow$ Root $\rightarrow$ Right
   - **Preorder**: Root $\rightarrow$ Left $\rightarrow$ Right
   - **Postorder**: Left $\rightarrow$ Right $\rightarrow$ Root
   - **Level-Order**: Breadth-First Queue-based exploration
3. **Binary Search Tree (`BinarySearchTree`)**:
   - Case records indexed and sorted by numerical **Risk Score**.
   - $O(\log N)$ average `insert()`, `search()`, `delete()`, `find_min()`, and `find_max()`.
   - Sorted ascending output via `inorder_traversal()`.
4. **Graph Representation (`Graph`)**:
   - Case escalation and jurisdictional routing network stored as an **Adjacency List**.
5. **Graph Traversals**:
   - **Breadth-First Search (BFS)** using `Queue`.
   - **Depth-First Search (DFS)** deep-path exploration.

---

## Testing & CLI Demos

### Run Standalone DSA CLI Demonstrator
```bash
python dsa.py
```

### Run Comprehensive Automated Unit Tests
```bash
python test_dsa.py
```