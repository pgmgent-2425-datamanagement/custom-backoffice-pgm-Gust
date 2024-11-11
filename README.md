# Backoffice & Database Project

## Studentgegevens

- **Naam:** Gust Pêtre
- **E-mail:** gust.petre@student.arteveldehs.be

## Projectomschrijving

Deze applicatie is een backoffice-systeem voor het beheren van een online boekencollectie. De backoffice is ontwikkeld voor gebruik door beheerders, waarmee zij boeken, auteurs, genres en uitgevers in een centrale database kunnen aanmaken, bijwerken, verwijderen en bekijken. Dit systeem helpt de beheerders om op een efficiënte manier informatie over boeken te beheren en te structureren.

## Databaseontwerp

De database voor deze applicatie is ontworpen met de volgende kernentiteiten:

- **Boeken**: Informatie over elk boek in de collectie, gekoppeld aan een auteur, uitgever, en meerdere genres.
- **Auteurs**: Gegevens van auteurs die aan één of meerdere boeken zijn gekoppeld.
- **Genres**: Verschillende genres die boeken beschrijven, zoals fictie, non-fictie, etc.
- **Uitgevers**: Informatie over de uitgeverijen die verantwoordelijk zijn voor het uitgeven van de boeken.

De relaties zijn gedefinieerd zodat een boek meerdere genres kan hebben en een auteur verschillende boeken kan hebben.

## Inloggen op de Backoffice

Om toegang te krijgen tot de backoffice, gebruik de volgende inloggegevens:

- **URL**: [URL van de Backoffice]
- **Gebruikersnaam**: `admin`
- **Wachtwoord**: `password123`

*Let op*: Deze inloggegevens zijn alleen voor testdoeleinden en moeten worden gewijzigd in een productieomgeving voor beveiliging.

## Installatie en Configuratie

1. **Clone de repository**:
   ```bash
   git clone https://github.com/[jouw-gebruikersnaam]/project-backoffice.git
   cd project-backoffice
