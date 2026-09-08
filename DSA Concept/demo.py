from linked_list import SinglyLinkedList
from stack import LinkedStack
from queue import LinkedQueue
from expression_handler import ExpressionHandler
from efficiency_engine import EfficiencyEngine
from data import SAMPLE_NUMERIC_DATASET, SAMPLE_COMPLAINT_RECORDS

def run_demo():
    print("\n" + "="*60)
    print("CCMS DSA - PHASE 1 DEMO")
    print("="*60)
    
    # 1. Dataset
    print("\n[1] DATASET:")
    print(f"Numeric: {SAMPLE_NUMERIC_DATASET}")
    print(f"Complaints: {len(SAMPLE_COMPLAINT_RECORDS)} items")
    
    # 2. Linked List
    print("\n[2] LINKED LIST:")
    ll = SinglyLinkedList()
    for rec in SAMPLE_COMPLAINT_RECORDS:
        ll.insert_at_tail(rec)
    print(f"Inserted {ll.get_size()} records")
    found = ll.search("CCMS-2026-102")
    print(f"Search result: {found[1]['title'] if found else 'Not found'}")
    
    # 3. Stack & Queue
    print("\n[3] STACK & QUEUE:")
    s = LinkedStack()
    q = LinkedQueue()
    for item in ["Event-1", "Event-2", "Event-3"]:
        s.push(item)
        q.enqueue(item)
    print(f"Stack pop: {s.pop()}")
    print(f"Queue dequeue: {q.dequeue()}")
    
    # 4. Expression Handler
    print("\n[4] EXPRESSION HANDLING:")
    expr = "(5000*2)+(15*100)-500"
    postfix = ExpressionHandler.infix_to_postfix(expr)
    result = ExpressionHandler.evaluate_postfix(postfix)
    print(f"Infix: {expr}")
    print(f"Postfix: {' '.join(postfix)}")
    print(f"Result: {result}")
    
    # 5. Efficiency
    print("\n[5] EFFICIENCY:")
    bench = EfficiencyEngine.run_benchmark("factorial", 15)
    print(f"Algorithm: {bench['algorithm']}")
    print(f"Iterative: {bench['iterative']}")
    print(f"Analysis: {bench['analysis']['reason']}")
    
    print("\n" + "="*60 + "\n")

if __name__ == "__main__":
    run_demo()
