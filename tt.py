from static_data import STATIC_DEPARTMENTS, STATIC_OFFICERS, STATIC_COMPLAINTS
from collections import deque

# ──────────────────────────────────────────────
# BUILD GRAPH: Department → Officers → Complaints
# ──────────────────────────────────────────────

graph = {}

# 1. Add every department as a node
for dept in STATIC_DEPARTMENTS:
    graph[dept["name"]] = []

# 2. Link departments → their officers
for officer in STATIC_OFFICERS:
    dept_name = officer["department"]
    if dept_name in graph:
        graph[dept_name].append(officer["name"])
    graph[officer["name"]] = []   # officer node (empty for now)

# 3. Link officers → their complaints
for complaint in STATIC_COMPLAINTS:
    officer_name = complaint.get("assigned_officer")
    if officer_name and officer_name in graph:
        graph[officer_name].append(complaint["complaint_id"])
    if complaint["complaint_id"] not in graph:
        graph[complaint["complaint_id"]] = []   # complaint is a leaf node

# ──────────────────────────────────────────────
# PRINT THE GRAPH
# ──────────────────────────────────────────────

print("=" * 55)
print("  CCMS GRAPH  (Department → Officers → Complaints)")
print("=" * 55)
for node, neighbors in graph.items():
    print(f"\n  {node}")
    for n in neighbors:
        print(f"    └─ {n}")

# ──────────────────────────────────────────────
# BFS from a starting department
# ──────────────────────────────────────────────

def bfs(graph, start):
    visited = set()
    queue = deque([start])
    order = []
    while queue:
        node = queue.popleft()
        if node not in visited:
            visited.add(node)
            order.append(node)
            for neighbor in graph.get(node, []):
                if neighbor not in visited:
                    queue.append(neighbor)
    return order

start_node = "Land Registration & Revenue"
print("\n" + "=" * 55)
print(f"  BFS from: {start_node}")
print("=" * 55)
result = bfs(graph, start_node)
print(" -> ".join(result))