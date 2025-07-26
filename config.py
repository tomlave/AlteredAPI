from KEY import (API_KEY)

# Lien de API pour les carte
API_URL = 'https://api.altered.gg/public/cards'

# "Accept-Language": "fr-FR",
headers = {"Authorization": API_KEY, "Accept-Language": "fr-FR"}

# Nom et Code du SET [['BTG','CORE'],['TBF','ALIZE']]
SETALL = [['BTG', 'CORE'], ['TBF', 'ALIZE']]

# Image par page a exporté (36 max)
ItemPerPage = 36

# Nombre de page à exporté
PAGE = 16

# Langue exporté
# headers = {"Accept-Language":"fr-FR"} #en-US

# Download PNG
DOWNLOAD_PNG = False
