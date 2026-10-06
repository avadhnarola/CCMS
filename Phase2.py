# CCMS - PHASE 2: STRUCTURED DATA REPRESENTATION
# ===============================================
from collections import deque
from static_data import (
    STATIC_COMPLAINTS,
    STATIC_DEPARTMENTS,
    STATIC_OFFICERS,
    STATIC_CATEGORIES
)

# =========================================================
# 1. BINARY TREE - Complaint Categories
# =========================================================

class Node:
    def __init__(self, data):
        self.data = data
        self.left = None
        self.right = None


# Build Category Binary Tree
root = Node("Corruption")
root.left = Node("Bribery")
root.right = Node("Fraud")

root.left.left = Node("Demand")
root.left.right = Node("Acceptance")

root.right.left = Node("Financial")
root.right.right = Node("Document")


# =========================================================
# 2. TREE TRAVERSALS
# =========================================================

def preorder(root):
    if root:
        print(root.data, end=" -> ")
        preorder(root.left)
        preorder(root.right)


def inorder(root):
    if root:
        inorder(root.left)
        print(root.data, end=" -> ")
        inorder(root.right)


def postorder(root):
    if root:
        postorder(root.left)
        postorder(root.right)
        print(root.data, end=" ")


print("\n--- 1 & 2. BINARY TREE & TRAVERSALS ---")
print("Preorder :", end=" ")
preorder(root)
print("END")

print("Inorder  :", end=" ")
inorder(root)
print("END")

print("Postorder:", end=" ")
postorder(root)
print("END")


# =========================================================
# 3. BINARY SEARCH TREE (BST) - Dynamic Search by ID
# =========================================================

class BSTNode:
    def __init__(self, complaint_id, data=None):
        self.id = complaint_id
        self.data = data or {}
        self.left = None
        self.right = None


class BST:
    def __init__(self):
        self.root = None

    def insert(self, root, complaint_id, data=None):
        if root is None:
            return BSTNode(complaint_id, data)

        if complaint_id < root.id:
            root.left = self.insert(root.left, complaint_id, data)
        elif complaint_id > root.id:
            root.right = self.insert(root.right, complaint_id, data)

        return root

    def search(self, root, complaint_id):
        """Dynamic O(log N) Search in BST by Complaint ID"""
        if root is None:
            return None

        if root.id == complaint_id:
            return root

        if complaint_id < root.id:
            return self.search(root.left, complaint_id)

        return self.search(root.right, complaint_id)

    def inorder(self, root):
        if root:
            self.inorder(root.left)
            print(f"  [{root.id}] {root.data.get('complaint_title', '')} | Dept: {root.data.get('sector', '')} | Officer: {root.data.get('assigned_officer', 'Unassigned')}")
            self.inorder(root.right)


# Build BST dynamically from static_data.STATIC_COMPLAINTS
bst = BST()
for c in STATIC_COMPLAINTS:
    bst.root = bst.insert(bst.root, c["complaint_id"], c)


def dynamic_search(bst, search_id):
    """Dynamic Search function to look up any complaint record by ID"""
    res = bst.search(bst.root, search_id)
    if res:
        print(f"\n[Search Result: {search_id}] -> FOUND")
        print(f"  * Title:    {res.data.get('complaint_title')}")
        print(f"  * Sector:   {res.data.get('sector')}")
        print(f"  * Severity: {res.data.get('severity')}")
        print(f"  * Status:   {res.data.get('complaint_status')}")
        print(f"  * Officer:  {res.data.get('assigned_officer', 'Unassigned')}")
    else:
        print(f"\n[Search Result: {search_id}] -> NOT FOUND")
    return res


print("\n\n--- 3. BINARY SEARCH TREE (BST from static_data.py) ---")
print("All Complaints in BST (Sorted Inorder by ID):")
bst.inorder(bst.root)

print("\nDynamic Search Tests:")
dynamic_search(bst, "CCMS-2026-1038")
dynamic_search(bst, "CCMS-2026-2237")
dynamic_search(bst, "CCMS-2026-9999")


# =========================================================
# GRAPH DATA
# Department -> Officers -> Complaints
# =========================================================

graph = {

    "Land Registration & Revenue": [
        "Senior Inspector A.",
        "Inspector M. Sharma"
    ],

    "Senior Inspector A.": [
        "CCMS-2026-1848",
        "CCMS-2026-1849"
    ],

    "Inspector M. Sharma": [
        "CCMS-2026-4366",
        "CCMS-2026-8632"
    ],

    # Complaint nodes
    "CCMS-2026-1848": [],
    "CCMS-2026-1849": [],
    "CCMS-2026-4366": [],
    "CCMS-2026-8632": []
}

# =========================================================
# 5. BFS TRAVERSAL (Level-by-Level Exploration)
# =========================================================

def bfs(graph, start):
    visited = set()
    queue = deque([start])
    order = []

    while queue:
        curr = queue.popleft()
        if curr not in visited:
            order.append(curr)
            visited.add(curr)
            for neighbor in graph.get(curr, []):
                if neighbor not in visited:
                    queue.append(neighbor)

    print(" -> ".join(order))
    return order


print("\n--- 5. BFS TRAVERSAL ---")
print("BFS from 'Land Registration & Revenue':")
bfs(graph, "Land Registration & Revenue")
