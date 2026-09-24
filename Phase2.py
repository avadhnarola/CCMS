# CCMS - PHASE 2
# Structured Data Representation

from collections import deque

class Node:
    def __init__(self, data):
        self.data = data
        self.left = None
        self.right = None


# Create Binary Tree
root = Node("Corruption")

root.left = Node("Bribery")
root.right = Node("Fraud")

root.left.left = Node("Land")
root.left.right = Node("Medical")

root.right.left = Node("Financial")
root.right.right = Node("Documents")


# Tree Traversal
def preorder(root):
    if root:
        print(root.data, end=" ")
        preorder(root.left)
        preorder(root.right)


def inorder(root):
    if root:
        inorder(root.left)
        print(root.data, end=" ")
        inorder(root.right)


def postorder(root):
    if root:
        postorder(root.left)
        postorder(root.right)
        print(root.data, end=" ")


print("\n--- BINARY TREE ---")

print("Preorder:")
preorder(root)

print("\nInorder:")
inorder(root)

print("\nPostorder:")
postorder(root)


# Binary Search Tree [BST]
class BST:
    def __init__(self):
        self.root = None

    def insert(self, root, value):
        if root is None:
            return Node(value)

        if value < root.data:
            root.left = self.insert(root.left, value)
        else:
            root.right = self.insert(root.right, value)

        return root

    def search(self, root, value):
        if root is None:
            return False

        if root.data == value:
            return True

        if value < root.data:
            return self.search(root.left, value)

        return self.search(root.right, value)


# Complaint IDs
complaints = [
    "CCMS-1024",
    "CCMS-1012",
    "CCMS-1035",
    "CCMS-1008",
    "CCMS-1040"
]

bst = BST()

for complaint in complaints:
    bst.root = bst.insert(bst.root, complaint)


print("\n\n--- BINARY SEARCH TREE ---")

print("Search CCMS-1035:",
      bst.search(bst.root, "CCMS-1035"))

print("Search CCMS-9999:",
      bst.search(bst.root, "CCMS-9999"))
    
# =========================================================
# 4. GRAPH - Departments and Officers
# =========================================================

graph = {
    "Land Department": ["Officer A", "Complaint C101"],
    "Officer A": ["Land Department", "Complaint C101"],
    "Complaint C101": ["Officer A"],

    "Revenue Department": ["Officer B", "Complaint C102"],
    "Officer B": ["Revenue Department", "Complaint C102"],
    "Complaint C102": ["Officer B"]
}


print("\n--- GRAPH ---")

for node in graph:
    print(node, "->", graph[node])


# =========================================================
# 5. BFS TRAVERSAL
# =========================================================

def bfs(graph, start):

    visited = set()
    queue = deque([start])

    while queue:

        current = queue.popleft()

        if current not in visited:
            print(current, end=" -> ")
            visited.add(current)

            for neighbour in graph[current]:
                if neighbour not in visited:
                    queue.append(neighbour)


print("\n\n--- BFS TRAVERSAL ---")

print("Starting from Land Department:")
bfs(graph, "Land Department")