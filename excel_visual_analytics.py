"""
Visual Analytics from Excel Sheet
==================================
Simple Python script to:
1. Read data from an Excel file (.xlsx)
2. Generate 3 clean graphs with simple, readable fonts
3. Save/display the visual dashboard
"""

import os
import pandas as pd
# pyrefly: ignore [missing-import]
import matplotlib.pyplot as plt

# ==============================================================================
# 1. SET CLEAN & SIMPLE FONT (No sci-fi or complex fonts)
# ==============================================================================
plt.rcParams['font.family'] = 'sans-serif'
plt.rcParams['font.sans-serif'] = ['Arial', 'Segoe UI', 'DejaVu Sans', 'Calibri']
plt.rcParams['font.size'] = 11
plt.rcParams['axes.titlesize'] = 13
plt.rcParams['axes.labelsize'] = 11

EXCEL_FILE = "ccms_dataset.xlsx"

# ==============================================================================
# 2. CREATE SAMPLE EXCEL IF IT DOES NOT EXIST (For immediate testing)
# ==============================================================================
def create_sample_excel_if_needed():
    if not os.path.exists(EXCEL_FILE):
        print(f"[*] Creating sample Excel sheet: {EXCEL_FILE}")
        
        # Sheet 1: Departments
        dept_data = {
            "Department": [
                "Police & Law", 
                "Land Revenue", 
                "Municipality", 
                "Healthcare", 
                "Education", 
                "Transport"
            ],
            "Total_Cases": [42, 65, 51, 29, 34, 38],
            "Resolved_Cases": [38, 60, 48, 28, 31, 35]
        }
        
        # Sheet 2: Complaints
        complaints_data = {
            "Complaint_ID": ["C-101", "C-102", "C-103", "C-104", "C-105", "C-106", "C-107", "C-108"],
            "Severity": ["Critical", "High", "High", "High", "High", "High", "Medium", "Medium"],
            "Status": [
                "Under Review", 
                "Under Review", 
                "Under Review", 
                "Under Review", 
                "Investigation Active", 
                "Assigned", 
                "Pending", 
                "Resolved"
            ]
        }
        
        with pd.ExcelWriter(EXCEL_FILE) as writer:
            pd.DataFrame(dept_data).to_excel(writer, sheet_name="Departments", index=False)
            pd.DataFrame(complaints_data).to_excel(writer, sheet_name="Complaints", index=False)
        print("[+] Sample Excel file created successfully!\n")


# ==============================================================================
# 3. READ DATA FROM EXCEL SHEET
# ==============================================================================
def load_data():
    create_sample_excel_if_needed()
    print(f"[*] Reading data from '{EXCEL_FILE}'...")
    
    # Read both sheets
    df_dept = pd.read_excel(EXCEL_FILE, sheet_name="Departments")
    df_comp = pd.read_excel(EXCEL_FILE, sheet_name="Complaints")
    
    print("\n--- Departments Data ---")
    print(df_dept)
    print("\n--- Complaints Data ---")
    print(df_comp.head())
    
    return df_dept, df_comp


# ==============================================================================
# 4. CREATE 3 VISUAL ANALYTICS CHARTS (Clean Simple Design)
# ==============================================================================
def generate_visual_analytics(df_dept, df_comp):
    print("\n[*] Generating graphs...")
    
    # Create figure with 3 subplots (1 wide top, 2 bottom)
    fig = plt.figure(figsize=(14, 10))
    gs = fig.add_gridspec(2, 2, height_ratios=[1.1, 1], hspace=0.35, wspace=0.25)
    
    # Color palette (Clean & Professional)
    COLOR_BLUE = "#0284c7"
    COLOR_GREEN = "#16a34a"
    COLOR_ROSE = "#e11d48"
    COLOR_AMBER = "#d97706"
    COLOR_CYAN = "#0891b2"
    COLOR_VIOLET = "#7c3aed"
    COLOR_GRAY = "#64748b"
    
    # -------------------------------------------------------------------------
    # GRAPH 1 (Top Full-Width): Grouped Bar Chart (Total vs Resolved by Dept)
    # -------------------------------------------------------------------------
    ax1 = fig.add_subplot(gs[0, :])
    # pyrefly: ignore [missing-import]
    import numpy as np
    
    x = np.arange(len(df_dept["Department"]))
    width = 0.35
    
    rects1 = ax1.bar(x - width/2, df_dept["Total_Cases"], width, label="Total Cases", color=COLOR_BLUE, edgecolor="none", zorder=3)
    rects2 = ax1.bar(x + width/2, df_dept["Resolved_Cases"], width, label="Resolved Cases", color=COLOR_GREEN, edgecolor="none", zorder=3)
    
    ax1.set_title("Department Caseload & Resolution Comparison", fontsize=14, fontweight="bold", pad=12)
    ax1.set_xticks(x)
    ax1.set_xticklabels(df_dept["Department"], fontsize=11)
    ax1.set_ylabel("Number of Cases", fontsize=11)
    ax1.legend(frameon=True, facecolor="#f8fafc", edgecolor="#cbd5e1")
    ax1.grid(axis='y', linestyle='--', alpha=0.5, zorder=0)
    
    # Add values on top of bars
    ax1.bar_label(rects1, padding=3, fontsize=9)
    ax1.bar_label(rects2, padding=3, fontsize=9)
    
    # -------------------------------------------------------------------------
    # GRAPH 2 (Bottom Left): Donut Chart (Severity Distribution)
    # -------------------------------------------------------------------------
    ax2 = fig.add_subplot(gs[1, 0])
    sev_counts = df_comp["Severity"].value_counts()
    
    sev_palette = {
        "Critical": COLOR_ROSE,
        "High": COLOR_AMBER,
        "Medium": COLOR_CYAN,
        "Low": COLOR_GREEN
    }
    colors2 = [sev_palette.get(s, COLOR_GRAY) for s in sev_counts.index]
    
    wedges, texts, autotexts = ax2.pie(
        sev_counts, 
        labels=sev_counts.index, 
        autopct='%1.0f%%', 
        startangle=140,
        colors=colors2,
        wedgeprops=dict(width=0.4, edgecolor='white', linewidth=2),
        pctdistance=0.8
    )
    
    for autotext in autotexts:
        autotext.set_color('white')
        autotext.set_fontsize(10)
        autotext.set_fontweight('bold')
        
    ax2.set_title("Threat Severity Breakdown", fontsize=13, fontweight="bold", pad=10)
    
    # -------------------------------------------------------------------------
    # GRAPH 3 (Bottom Right): Horizontal Bar Chart (Investigation Status)
    # -------------------------------------------------------------------------
    ax3 = fig.add_subplot(gs[1, 1])
    status_counts = df_comp["Status"].value_counts().sort_values(ascending=True)
    
    bars = ax3.barh(status_counts.index, status_counts.values, color=COLOR_VIOLET, height=0.55, zorder=3)
    ax3.set_title("Complaint Investigation Pipeline", fontsize=13, fontweight="bold", pad=10)
    ax3.set_xlabel("Number of Complaints", fontsize=11)
    ax3.grid(axis='x', linestyle='--', alpha=0.5, zorder=0)
    ax3.bar_label(bars, padding=4, fontsize=10, fontweight="bold")
    
    # Save chart as high-resolution image
    output_image = "visual_analytics_dashboard.png"
    plt.savefig(output_image, dpi=200, bbox_inches='tight')
    print(f"[+] Graphs created and saved as '{output_image}'!")
    
    # Show chart window
    try:
        plt.show()
    except Exception:
        pass


# ==============================================================================
# MAIN ENTRYPOINT
# ==============================================================================
if __name__ == "__main__":
    df_dept, df_comp = load_data()
    generate_visual_analytics(df_dept, df_comp)
