from node import Node

class LinkedStack:
    def __init__(self):
        self.top = None
        self.size = 0

    def is_empty(self):
        return self.top is None

    def push(self, item):
        new_node = Node(item)
        new_node.next = self.top
        self.top = new_node
        self.size += 1

    def pop(self):
        if self.is_empty():
            return None
        item = self.top.data
        self.top = self.top.next
        self.size -= 1
        return item

    def peek(self):
        return self.top.data if self.top else None

    def to_list(self):
        items = []
        current = self.top
        while current:
            items.append(current.data)
            current = current.next
        return items
