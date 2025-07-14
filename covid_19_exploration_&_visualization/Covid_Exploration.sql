USE ProtfolioProject;

SELECT *
FROM covidvacination1;

SELECT *
FROM coviddeath1;



-- Select Data
SELECT location, date, total_cases,new_cases, total_deaths, population
FROM coviddeath1
ORDER BY 1,2;


-- Total Cases vs Total Deaths
-- Shows likelihood of dying if you contract covid in your country
SELECT location, date, total_cases, total_deaths, (total_deaths/total_cases)*100 AS Deathpercentage
FROM coviddeath1
WHERE location = 'Canada' 
ORDER BY 1,2;


-- Total Cases vs Population
-- Show what percentage of popuation got Covid
SELECT location, date, population, total_cases, (total_cases/population)*100 AS PercentageOfPopulationInfected
FROM coviddeath1
WHERE location = 'Canada'
ORDER BY 1,2;


-- Countries with Hightest Infection Rate compared to Population
SELECT location, population, MAX(total_cases) AS HighestInfectionConut, MAX((total_cases/population))*100 AS PercentageOfPopulationInfected
FROM coviddeath1
Where location not in ('High Income', 'Low income', 'Low middle income')
GROUP BY location, population
ORDER BY PercentageOfPopulationInfected DESC;


-- Countries With Highest Death Count per Population
SELECT location, MAX(CAST(total_deaths AS SIGNED)) AS TotalDeathCount 
FROM coviddeath1
WHERE continent is not NULL
AND location not in ('High Income', 'Low income', 'Low middle income')
GROUP BY location
ORDER BY TotalDeathCount DESC;


-- BREAKING THING DOWN BY CONTINENT
SELECT location , MAX(CAST(total_deaths AS SIGNED)) AS TotalDeathCount 
FROM coviddeath1
WHERE continent is not NULL
AND location not in ('High Income', 'Low income', 'Low middle income')
GROUP BY location
ORDER BY TotalDeathCount DESC;


-- Continents with the Highest Death Count
SELECT continent , MAX(CAST(total_deaths AS SIGNED)) AS TotalDeathCount 
FROM coviddeath1
WHERE continent is not NULL
AND location not in ('High Income', 'Low income', 'Low middle income')
GROUP BY continent
ORDER BY TotalDeathCount DESC;


-- GLOBAL NUMBERS (Death Percentage of the whole world)
SELECT SUM(new_cases) AS Total_Cases, SUM(CAST(new_deaths AS SIGNED)) AS Total_Death, SUM(CAST(new_deaths AS SIGNED))/SUM(new_cases)*100 AS Deathpercentage
FROM coviddeath1
WHERE continent is not NULL
AND location not in ('High Income', 'Low income', 'Low middle income')
-- GROUP BY date
ORDER BY 1,2;


-- Total Population vs Vaccinations
SELECT dea.continent, dea.location, dea.date, dea.population, vac.new_vaccinations, 
	   SUM(CAST(vac.new_vaccinations as SIGNED)) OVER (PARTITION BY dea.location ORDER BY dea.location, dea.date) AS RollingPeopleVaccinated -- to find the total vaccination each date (rolling count)
FROM coviddeath1 dea JOIN covidvacination1 vac
	ON dea.location = vac.location
    AND dea.date = vac.date
WHERE dea.continent is not NULL AND dea.continent != ''
AND dea.location not in ('High Income', 'Low income', 'Low middle income')
ORDER BY 2,3;


-- Using CTE to perform Calculation on Partition By in previous query (Percentage of Vaccinated people vs Population)
With PopvsVac (Continent, Location, Date, Population, New_Vaccinations, RollingPeopleVaccinated)
as
(
SELECT dea.continent, dea.location, dea.date, dea.population, vac.new_vaccinations, 
	   SUM(CAST(vac.new_vaccinations as SIGNED)) OVER (PARTITION BY dea.location ORDER BY dea.location, dea.date) AS RollingPeopleVaccinated -- to find the total vaccination each date (rolling count)
FROM coviddeath1 dea JOIN covidvacination1 vac
	ON dea.location = vac.location
    AND dea.date = vac.date
)
Select *, (RollingPeopleVaccinated/Population)*100 AS VaccinatedPercentage
From PopvsVac ;

CREATE VIEW PercentagePopulationVaccinated as
SELECT dea.continent, dea.location, dea.date, dea.population, vac.new_vaccinations, 
	   SUM(CAST(vac.new_vaccinations as SIGNED)) OVER (PARTITION BY dea.location ORDER BY dea.location, dea.date) AS RollingPeopleVaccinated -- to find the total vaccination each date (rolling count)
FROM coviddeath1 dea JOIN covidvacination1 vac
	ON dea.location = vac.location
    AND dea.date = vac.date
WHERE dea.continent is not NULL AND dea.continent != ''
AND dea.location not in ('High Income', 'Low income', 'Low middle income');

SELECT *
FROM percentagepopulationvaccinated;



















