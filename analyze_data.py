import sqlite3

conn = sqlite3.connect('ccms_local.db')
conn.row_factory = sqlite3.Row
c = conn.cursor()

# ALL complaints
print("=== ALL COMPLAINTS ===")
c.execute("SELECT complaint_id, misconduct_category, sector, severity, complaint_status, created_at FROM complaints ORDER BY created_at")
for row in c.fetchall():
    print(dict(row))

# ALL departments
print("\n=== ALL DEPARTMENTS ===")
c.execute("SELECT * FROM departments")
for row in c.fetchall():
    print(dict(row))

# ALL categories
print("\n=== ALL CATEGORIES ===")
c.execute("SELECT * FROM categories")
for row in c.fetchall():
    print(dict(row))

# ALL officers
print("\n=== ALL OFFICERS ===")
c.execute("SELECT officer_id, name, rank, department, active_cases, status FROM officers")
for row in c.fetchall():
    print(dict(row))

# Monthly trend from complaints
print("\n=== MONTHLY COMPLAINT TREND ===")
c.execute("SELECT strftime('%Y-%m', created_at) as month, COUNT(*) as count FROM complaints GROUP BY month ORDER BY month")
for row in c.fetchall():
    print(dict(row))

# Status distribution
print("\n=== STATUS DISTRIBUTION ===")
c.execute("SELECT complaint_status, COUNT(*) as cnt FROM complaints GROUP BY complaint_status")
for row in c.fetchall():
    print(dict(row))

# Severity distribution
print("\n=== SEVERITY DISTRIBUTION ===")
c.execute("SELECT severity, COUNT(*) as cnt FROM complaints GROUP BY severity")
for row in c.fetchall():
    print(dict(row))

# Category distribution
print("\n=== CATEGORY DISTRIBUTION ===")
c.execute("SELECT misconduct_category, COUNT(*) as cnt FROM complaints GROUP BY misconduct_category ORDER BY cnt DESC")
for row in c.fetchall():
    print(dict(row))

# Sector distribution
print("\n=== SECTOR DISTRIBUTION ===")
c.execute("SELECT sector, COUNT(*) as cnt FROM complaints GROUP BY sector ORDER BY cnt DESC")
for row in c.fetchall():
    print(dict(row))

conn.close()
