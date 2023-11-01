USE ProtfolioProject;

SELECT location, COUNT(location) as count
FROM coviddeath1
GROUP BY location;

SELECT  location
FROM coviddeath1
where location  like 'Low%';

-- 1
-- GLOBAL NUMBERS (Death Percentage of the whole world)
SELECT SUM(new_cases) AS Total_Cases, SUM(CAST(new_deaths AS SIGNED)) AS Total_Death, SUM(CAST(new_deaths AS SIGNED))/SUM(new_cases)*100 AS Deathpercentage
FROM coviddeath1
WHERE continent != ''
AND location not in ('High Income', 'Low income')
ORDER BY 1,2;

-- 2
Select location, SUM(CAST(new_deaths as SIGNED)) as TotalDeathCount
From coviddeath1
Where continent = '' 
and location not in ('World', 'European Union', 'International', 'High income', 'Low income')
Group by location
Order by TotalDeathCount desc; 

-- 3
Select Location, Population, MAX(total_cases) as HighestInfectionCount,  Max((total_cases/population))*100 as PercentPopulationInfected
From coviddeath1
Where location not in ('High Income', 'Low income')
Group by Location, Population
order by PercentPopulationInfected desc;

-- 4
Select Location, Population,date, MAX(total_cases) as HighestInfectionCount,  Max((total_cases/population))*100 as PercentPopulationInfected
From coviddeath1
Where location not in ('High Income', 'Low income')
Group by Location, Population, date
Order by PercentPopulationInfected desc;



