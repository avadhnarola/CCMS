import sqlite3
import json

conn = sqlite3.connect('ccms_local.db')
conn.row_factory = sqlite3.Row
c = conn.cursor()

c.execute("SELECT name FROM sqlite_master WHERE type='table'")
tables = [row[0] for row in c.fetchall()]
print("TABLES:", tables)

for tname in tables:
    c.execute(f"PRAGMA table_info({tname})")
    cols = c.fetchall()
    print(f"\n--- TABLE: {tname} ---")
    col_names = [col[1] for col in cols]
    print("Columns:", col_names)
    c.execute(f"SELECT COUNT(*) FROM {tname}")
    cnt = c.fetchone()[0]
    print(f"Row count: {cnt}")
    if cnt > 0:
        c.execute(f"SELECT * FROM {tname} LIMIT 3")
        rows = c.fetchall()
        for row in rows:
            print(dict(row))

conn.close()
