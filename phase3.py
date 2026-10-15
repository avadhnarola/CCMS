import heapq

# 1. LINEAR SEARCH - Find a complaint (O(N) Time Complexity)
def linear_search(data, target):
    target_str = str(target).strip().upper()
    for idx, item in enumerate(data):
        item_id = str(item.get("complaint_id") or item.get("officer_id") or item.get("id") or "").strip().upper()
        if item_id == target_str or target_str in item_id:
            return item, idx + 1
    return None, len(data)


# 2. BINARY SEARCH - Find a complaint or officer by ID (O(log N) Time Complexity)
# Note: Input data must be sorted by the lookup ID
def binary_search(data, target, key="complaint_id"):
    if not data:
        return None, 0
    
    # Auto-detect ID key if not present
    if key not in data[0]:
        if "officer_id" in data[0]:
            key = "officer_id"
        elif "id" in data[0]:
            key = "id"

    # Ensure data is sorted for binary search
    sorted_data = sorted(data, key=lambda x: str(x.get(key, "")).upper())
    target_str = str(target).strip().upper()
    
    low = 0
    high = len(sorted_data) - 1
    steps = 0

    while low <= high:
        steps += 1
        mid = (low + high) // 2
        mid_val = str(sorted_data[mid].get(key, "")).strip().upper()

        if mid_val == target_str:
            return sorted_data[mid], steps
        elif mid_val < target_str:
            low = mid + 1
        else:
            high = mid - 1

    return None, steps


def _extract_merge_val(item, key):
    if key in ("incident_date", "date"):
        return str(item.get("incident_date") or item.get("date") or item.get("created_at") or "")
    if key in ("complaint_id", "id"):
        return str(item.get("complaint_id") or item.get("id") or "")
    if key in ("complaint_title", "title"):
        return str(item.get("complaint_title") or item.get("title") or "")
    if key in ("severity", "priority"):
        rank = {"Critical": 1, "High": 2, "Medium": 3, "Low": 4}
        sev = item.get("severity") or item.get("priority") or "Low"
        return rank.get(sev, 5)
    return str(item.get(key, "") or "")


# 3. MERGE SORT - Sort complaints by any attribute (O(N log N) Stable Divide and Conquer)
def merge_sort(data, key="complaint_id", reverse=False):
    if len(data) <= 1:
        return data

    mid = len(data) // 2
    left = merge_sort(data[:mid], key=key, reverse=reverse)
    right = merge_sort(data[mid:], key=key, reverse=reverse)

    result = []
    i = j = 0

    while i < len(left) and j < len(right):
        val_l = _extract_merge_val(left[i], key)
        val_r = _extract_merge_val(right[j], key)

        if isinstance(val_l, type(val_r)):
            condition = (val_l >= val_r) if reverse else (val_l <= val_r)
        else:
            condition = (str(val_l) >= str(val_r)) if reverse else (str(val_l) <= str(val_r))

        if condition:
            result.append(left[i])
            i += 1
        else:
            result.append(right[j])
            j += 1

    result.extend(left[i:])
    result.extend(right[j:])
    return result


# 4. PRIORITY QUEUE - Process urgent complaints first (Max/Min-Heap based on urgency)
def priority_queue(data):
    """
    Sequences all complaints by emergency urgency:
    Critical (Rank 1) -> High (Rank 2) -> Medium (Rank 3) -> Low (Rank 4)
    """
    rank = {"Critical": 1, "High": 2, "Medium": 3, "Low": 4}
    queue = []

    for idx, complaint in enumerate(data):
        priority = complaint.get("severity") or complaint.get("priority", "Low")
        priority_rank = rank.get(priority, 5)
        # Min-heap element: (priority_rank, idx, complaint) to safely avoid dict comparison
        heapq.heappush(queue, (priority_rank, idx, complaint))

    sorted_list = []
    while queue:
        rank_value, idx, complaint = heapq.heappop(queue)
        sorted_list.append(complaint)

    return sorted_list