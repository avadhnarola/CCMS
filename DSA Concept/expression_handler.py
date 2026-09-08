import re
from stack import LinkedStack

class ExpressionHandler:
    OPERATORS = {'+': 1, '-': 1, '*': 2, '/': 2, '^': 3}

    @staticmethod
    def tokenize(expr):
        return re.findall(r'\d+(?:\.\d+)?|[a-zA-Z_]\w*|[+\-*/^()]', expr)

    @classmethod
    def infix_to_postfix(cls, expr):
        tokens = cls.tokenize(expr)
        stack = LinkedStack()
        postfix = []
        
        for token in tokens:
            if re.match(r'^-?\d+(?:\.\d+)?$', token):
                postfix.append(token)
            elif token == '(':
                stack.push(token)
            elif token == ')':
                while not stack.is_empty() and stack.peek() != '(':
                    postfix.append(stack.pop())
                if not stack.is_empty():
                    stack.pop()
            elif token in cls.OPERATORS:
                while (not stack.is_empty() and stack.peek() != '(' and 
                       stack.peek() in cls.OPERATORS and 
                       cls.OPERATORS[stack.peek()] >= cls.OPERATORS[token]):
                    postfix.append(stack.pop())
                stack.push(token)
            else:
                postfix.append(token)
        
        while not stack.is_empty():
            postfix.append(stack.pop())
        
        return postfix

    @classmethod
    def evaluate_postfix(cls, tokens):
        stack = LinkedStack()
        for token in tokens:
            if re.match(r'^-?\d+(?:\.\d+)?$', token):
                stack.push(float(token) if '.' in token else int(token))
            elif token in cls.OPERATORS:
                b = stack.pop()
                a = stack.pop()
                if token == '+':
                    stack.push(a + b)
                elif token == '-':
                    stack.push(a - b)
                elif token == '*':
                    stack.push(a * b)
                elif token == '/':
                    stack.push(a / b if b != 0 else 0)
                elif token == '^':
                    stack.push(a ** b)
        return stack.pop() if not stack.is_empty() else 0
