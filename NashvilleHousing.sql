/*
Cleaning Data in SQL Queries
*/

USE PorfolioProject;
Select *
From NashvilleHousing;

SET SQL_SAFE_UPDATES = 0;  -- turn off safe update mode

/* Standardize Date Format */

SELECT
    SaleDate,
    DATE_FORMAT(STR_TO_DATE(SaleDate, '%M %e, %Y'), '%Y-%m-%d') AS ConvertedSaleDate
FROM NashvilleHousing;

Alter Table NashvilleHousing
ADD SaleDateConverted Date;


Update NashvilleHousing
SET SaleDate = DATE_FORMAT(STR_TO_DATE(SaleDate, '%M %e, %Y'), '%Y-%m-%d');


/* Populate Property Address Data */

Select *
From NashvilleHousing
-- Where PropertyAddress ='';
Order by ParcelID;

-- Update the PropertyAddress based on the ParcelID
Select a.ParcelID, a.PropertyAddress, b.ParcelID, b.PropertyAddress, COALESCE(NULLIF(a.PropertyAddress, ''), b.PropertyAddress) 
From NashvilleHousing a
JOIN NashvilleHousing b 
	on a.ParcelID = b.ParcelID
    and a.UniqueID <> b.UniqueID
Where a.PropertyAddress = '';


UPDATE NashvilleHousing a
JOIN NashvilleHousing b 
	ON a.ParcelID = b.ParcelID 
    AND a.UniqueID <> b.UniqueID
SET a.PropertyAddress = COALESCE(NULLIF(a.PropertyAddress, ''), b.PropertyAddress)
WHERE a.PropertyAddress = '';


/* Breaking out Address into Individual Columns (Adress, City, State) */

-- Property Address
Select PropertyAddress
From NashvilleHousing;

Select 
	substring(PropertyAddress, 1, LOCATE(',',PropertyAddress) - 1) as Address,
    substring(PropertyAddress, LOCATE(',',PropertyAddress) +1, LENGTH(PropertyAddress)) as City
From NashvilleHousing;

Alter Table NashvilleHousing
ADD PropertySplitAddress Varchar(255);


Update NashvilleHousing
Set PropertySplitAddress = substring(PropertyAddress, 1, LOCATE(',',PropertyAddress) - 1);

Alter Table NashvilleHousing
ADD PropertySplitCity Varchar(255);

Update NashvilleHousing
Set PropertySplitCity =  substring(PropertyAddress, LOCATE(',',PropertyAddress) +1, LENGTH(PropertyAddress));


-- Owner Address 
Select OwnerAddress
From NashvilleHousing;

Select 
    TRIM(SUBSTRING_INDEX(OwnerAddress, ',', 1)) AS Address,   -- Extract the part before the first comma
    TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(OwnerAddress, ',', -2), ',', 1)) AS City, -- Extract the part between the second to last comma
    TRIM(SUBSTRING_INDEX(OwnerAddress, ',', -1)) AS State	-- Extract the part with the fist comma from the back (-1)
From NashvilleHousing;

Alter Table NashvilleHousing
ADD OwnerSplitAddress Varchar(255);

Update NashvilleHousing
Set OwnerSplitAddress = TRIM(SUBSTRING_INDEX(OwnerAddress, ',', 1));

Alter Table NashvilleHousing
ADD OwnerSplitCity Varchar(255);

Update NashvilleHousing
Set OwnerSplitCity = TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(OwnerAddress, ',', -2), ',', 1));

Alter Table NashvilleHousing
ADD OwnerSplitState Varchar(255);

Update NashvilleHousing
Set OwnerSplitState = TRIM(SUBSTRING_INDEX(OwnerAddress, ',', -1));


/* Change Y and N to Yes and No in "Sold as Vacant" field */

Select Distinct(SoldAsVacant), Count(SoldAsVacant)
From NashvilleHousing
Group By SoldAsVacant
Order By 2;

Update NashvilleHousing
Set SoldAsVacant = Case 
	When SoldAsVacant = 'Y' Then 'Yes'
	When SoldAsVacant = 'N' Then 'No'
	Else SoldAsVacant
	END;
    
    
/* Remove Duplicate*/

-- find duplicate
WITH RowNumCTE AS(
	Select *, 
    row_number() Over(partition by ParcelID,PropertyAddress, SalePrice, SaleDate, LegalReference ORDER BY UniqueID) row_num 
	From NashvilleHousing
)
Delete
FROM RowNumCTE
Where row_num > 1;

DELETE n1
FROM NashvilleHousing n1
JOIN NashvilleHousing n2
  ON n1.ParcelID = n2.ParcelID
  AND n1.PropertyAddress = n2.PropertyAddress
  AND n1.SalePrice = n2.SalePrice
  AND n1.SaleDate = n2.SaleDate
  AND n1.LegalReference = n2.LegalReference
  AND n1.UniqueID < n2.UniqueID;


/* Delete Unused Columns */

Alter Table NashvilleHousing
Drop Column OwnerAddress, 
Drop Column TaxDistrict, 
Drop Column PropertyAddress;



SET SQL_SAFE_UPDATES = 1; -- turn it on again


