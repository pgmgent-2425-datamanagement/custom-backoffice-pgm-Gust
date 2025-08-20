# Backoffice & Database Project

## Studentgegevens

- **Naam:** Gust Pêtre
- **E-mail:** gust.petre@student.arteveldehs.be

## Projectbeschrijving

Deze applicatie is een backoffice systeem voor het beheren van een online boekencollectie. Hier kunnen ze boeken, auteurs, genres en uitgevers aanmaken, bewerken, verwijderen en bekijk. Dit systeem helpt om boekinformatie efficiënt te beheren en te structureren.

## Functionaliteiten

- Volledige CRUD voor boeken en auteurs
- Bestandsupload (afbeelding)
- Een-op-veel relatie: selecteer auteur voor een boek (dropdown)
- Veel-op-veel relatie: ken genres toe aan een boek (checkbox-lijst)
- Dashboard met 2 statistieken (boeken per genre, boeken per jaar)
- Bestandsbeheerder voor geüploade bestanden
- Zoeken en sorteren in de boekenlijst
- Publieke API (boeken ophalen)
- Beschermd tegen SQL injection (prepared statements)
- Moderne layout met Bootstrap (Sass)

## API Gebruik

### Boeken ophalen

- **GET** `/api/books`
- Optioneel zoeken: `/api/books?search=harry`
- **Resultaat:** JSON lijst van boeken

## Bestandsbeheerder

- Ga naar `/filemanager` om alle geüploade bestanden te bekijken en te verwijderen.

## Dashboard

- De homepage toont 2 grafieken:
  - Boeken per genre (staafdiagram)
  - Boeken per publicatiejaar (lijndiagram)

## Beveiliging

- Alle database queries gebruiken prepared statements (SQL injection onmogelijk)
- Uploads worden opgeslagen in een aparte map (`public/uploads/`)

## Overige Informatie

- Project gebruikt het base MVC patroon
- Bootstrap/Sass voor styling
- Zie code en commentaar voor verdere uitleg

---
