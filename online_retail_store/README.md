# 🛒 Online Retail Customer Segmentation

This project performs customer segmentation for an online retail store using machine learning techniques. By applying RFM (Recency, Frequency, Monetary) analysis and KMeans clustering, we categorize customers into actionable groups for targeted marketing.

---

## 📊 Overview

**Goal**: Identify distinct customer groups based on purchasing behavior  
**Outcome**: Business can tailor marketing strategies to increase customer engagement, retention, and revenue

---

## 📁 Dataset

- **Source**: [UCI Machine Learning Repository - Online Retail II](https://archive.ics.uci.edu/ml/datasets/Online+Retail+II)
- **Features**:
  - `InvoiceNo`, `StockCode`, `Description`, `Quantity`, `InvoiceDate`, `UnitPrice`, `CustomerID`, `Country`
- **Time Frame**: 2009-2010
- **Scope**: Focused on UK transactions with valid Customer IDs

---

## 🔧 Methodology

### 1. Preprocessing
- Removed:
  - Missing `CustomerID`
  - Canceled transactions (e.g., `InvoiceNo` with “C”)
  - Negative `Quantity` and `UnitPrice`
- Feature created: `TotalPrice = Quantity * UnitPrice`

### 2. RFM Analysis
- **Recency**: Days since last purchase
- **Frequency**: Number of purchases
- **Monetary**: Total spending

### 3. Clustering
- Algorithm: `KMeans`
- Optimal clusters (`k`) chosen using the **Elbow Method**
- Data normalized using `StandardScaler`

---

## 🛠️ Tools & Libraries

- Python (Jupyter Notebook)
- `pandas`, `numpy`
- `matplotlib`, `seaborn`
- `scikit-learn` for clustering and scaling

---

## 📌 Usage

```bash
# Install dependencies
pip install pandas numpy matplotlib seaborn scikit-learn

# Run the notebook
jupyter notebook online_retail_project.ipynb
