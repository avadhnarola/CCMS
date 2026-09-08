from node import Node

class SinglyLinkedList:
    def __init__(self):
        self.head = None
        self.size = 0

    def is_empty(self):
        return self.head is None

    def get_size(self):
        return self.size

    def insert_at_head(self, data):
        new_node = Node(data)
        new_node.next = self.head
        self.head = new_node
        self.size += 1

    def insert_at_tail(self, data):
        new_node = Node(data)
        if self.head is None:
            self.head = new_node
        else:
            current = self.head
            while current.next:
                current = current.next
            current.next = new_node
        self.size += 1

    def delete_by_value(self, key):
        if self.head is None:
            return False
        if self.head.data == key or (isinstance(self.head.data, dict) and self.head.data.get('id') == key):
            self.head = self.head.next
            self.size -= 1
            return True
        current = self.head
        while current.next:
            if current.next.data == key or (isinstance(current.next.data, dict) and current.next.data.get('id') == key):
                current.next = current.next.next
                self.size -= 1
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
            elements.append(current.data)
            current = current.next
        return elements

    def to_list(self):
        nodes = []
        current = self.head
        idx = 0
        while current:
            nodes.append({"index": idx, "data": current.data})
            current = current.next
            idx += 1
        return nodes

    def clear(self):
        self.head = None
        self.size = 0
