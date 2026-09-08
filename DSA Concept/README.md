# DSA Concept - Data Structures and Algorithms

This folder contains a modular implementation of fundamental Data Structures and Algorithms concepts.

## Folder Structure

```
DSA Concept/
├── node.py                  # Basic Node class used by all linked structures
├── linked_list.py           # Singly Linked List implementation
├── stack.py                 # Stack (LIFO) implementation
├── queue.py                 # Queue (FIFO) implementation
├── expression_handler.py    # Infix to Postfix conversion and evaluation
├── efficiency_engine.py     # Algorithm efficiency comparison (Iterative vs Recursive)
├── data.py                  # Sample data for testing
├── demo.py                  # Main demonstration script
├── __init__.py              # Package initialization
└── README.md                # This file
```

## Files Overview

### node.py
Basic Node class used in linked data structures.
- `Node`: Simple node with data and next pointer

### linked_list.py
Singly Linked List for dynamic data storage.
- `SinglyLinkedList`: Supports insert (head/tail), delete, search, traverse, and clear operations
- Time Complexity: O(1) for head insertion, O(N) for tail insertion/deletion

### stack.py
LIFO (Last In First Out) Stack implementation using linked nodes.
- `LinkedStack`: Push, Pop, Peek, and traversal operations
- Time Complexity: O(1) for all operations

### queue.py
FIFO (First In First Out) Queue implementation using linked nodes.
- `LinkedQueue`: Enqueue, Dequeue, Peek, and traversal operations
- Time Complexity: O(1) for all operations

### expression_handler.py
Converts and evaluates mathematical expressions.
- `ExpressionHandler`: Infix to Postfix conversion, Postfix evaluation
- Supports: +, -, *, /, ^ operators with proper precedence

### efficiency_engine.py
Compares algorithm efficiency between iterative and recursive implementations.
- `EfficiencyEngine`: Benchmarks factorial, fibonacci, and binary search
- Provides execution time, step count, and space complexity analysis

### data.py
Contains sample datasets for testing and demonstration.
- Sample numeric dataset
- Sample sectors dataset
- Sample complaint records (CCMS domain data)

### demo.py
Main demonstration script showing all DSA concepts in action.

## Usage

### Run Demo
```bash
cd "DSA Concept"
python demo.py
```

### Use as Package
```python
from node import Node
from linked_list import SinglyLinkedList
from stack import LinkedStack
from queue import LinkedQueue
from expression_handler import ExpressionHandler
from efficiency_engine import EfficiencyEngine

# Create and use data structures
ll = SinglyLinkedList()
ll.insert_at_tail("data")
```

## Features

✅ Clean, modular code structure
✅ No unnecessary type hints or complex docstrings
✅ Easy to read and understand
✅ All operations well-tested
✅ Separated concerns (one concept per file)

## Example Output

```
============================================================
CCMS DSA - PHASE 1 DEMO
============================================================

[1] DATASET:
Numeric: [10, 25, 42, 55, 78, 99, 120, 150, 200]
Complaints: 4 items

[2] LINKED LIST:
Inserted 4 records
Search result: Procurement Tender Bribery in Medical Supplies

[3] STACK & QUEUE:
Stack pop: Event-3
Queue dequeue: Event-1

[4] EXPRESSION HANDLING:
Infix: (5000*2)+(15*100)-500
Postfix: 5000 2 * 15 100 * + 500 -
Result: 11000

[5] EFFICIENCY:
Algorithm: factorial
Iterative: {'value': 1307674368000, 'steps': 14, 'time': 84.6}
Analysis: Iterative: O(1) space, Recursive: 15 stack frames

============================================================
```
