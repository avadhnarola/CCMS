from node import Node

class Queue:
    def __init__(self):
        self.front = None
        self.rear = None
        self.size = 0

    def is_empty(self):
        return self.front is None

    def enqueue(self, item):
        new_node = Node(item)
        if not self.rear:
            self.front = new_node
            self.rear = new_node
        else:
            self.rear.next = new_node
            self.rear = new_node
        self.size += 1

    def dequeue(self):
        if self.is_empty():
            return None
        item = self.front.data
        self.front = self.front.next
        if not self.front:
            self.rear = None
        self.size -= 1
        return item

    def peek(self):
        return self.front.data if self.front else None

    def to_list(self):
        items = []
        current = self.front
        while current:
            items.append(current.data)
            current = current.next
        return items
