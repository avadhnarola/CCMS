import time
from linked_list import SinglyLinkedList

class EfficiencyEngine:
    @staticmethod
    def binary_search_iter(arr, target):
        low, high, steps = 0, len(arr) - 1, 0
        while low <= high:
            steps += 1
            mid = (low + high) // 2
            if arr[mid] == target:
                return mid, steps
            elif arr[mid] < target:
                low = mid + 1
            else:
                high = mid - 1
        return -1, steps

    @staticmethod
    def factorial_iter(n):
        result, steps = 1, 0
        for i in range(2, n + 1):
            steps += 1
            result *= i
        return result, max(1, steps)

    @staticmethod
    def factorial_rec(n, steps=0):
        steps += 1
        if n <= 1:
            return 1, steps
        sub, final_steps = EfficiencyEngine.factorial_rec(n - 1, steps)
        return n * sub, final_steps

    @staticmethod
    def fibonacci_iter(n):
        if n <= 0:
            return 0, 1
        if n == 1:
            return 1, 1
        a, b, steps = 0, 1, 0
        for _ in range(2, n + 1):
            steps += 1
            a, b = b, a + b
        return b, steps

    @classmethod
    def run_benchmark(cls, algo, n):
        result = {
            "algorithm": algo,
            "input": n,
            "iterative": {},
            "recursive": {},
            "analysis": {}
        }
        
        if algo == "factorial":
            n = min(n, 20)
            t0 = time.perf_counter_ns()
            vi, si = cls.factorial_iter(n)
            ti = (time.perf_counter_ns() - t0) / 1000
            
            t0 = time.perf_counter_ns()
            vr, sr = cls.factorial_rec(n)
            tr = (time.perf_counter_ns() - t0) / 1000
            
            result["iterative"] = {
                "value": vi,
                "steps": si,
                "time": round(ti, 3)
            }
            result["recursive"] = {
                "value": vr,
                "steps": sr,
                "time": round(tr, 3)
            }
            result["analysis"] = {
                "winner": "Iterative",
                "reason": f"Iterative: O(1) space, Recursive: {sr} stack frames"
            }
        
        elif algo == "fibonacci":
            n = min(n, 30)
            t0 = time.perf_counter_ns()
            vi, si = cls.fibonacci_iter(n)
            ti = (time.perf_counter_ns() - t0) / 1000
            
            t0 = time.perf_counter_ns()
            vr, sr = cls.fibonacci_iter(n)
            tr = (time.perf_counter_ns() - t0) / 1000
            
            result["iterative"] = {
                "value": vi,
                "steps": si,
                "time": round(ti, 3)
            }
            result["recursive"] = {
                "value": vr,
                "steps": sr,
                "time": round(tr, 3)
            }
            result["analysis"] = {
                "winner": "Iterative",
                "reason": f"Iterative: {si} steps, much better"
            }
        
        return result
