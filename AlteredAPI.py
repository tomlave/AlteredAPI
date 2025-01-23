#Import les dependance
import requests
import os
import json

#Import le variable
from config import (
  API_URL,
  SAVE_PATH_IMG,
  SAVE_PATH_JSON,
  SETNAME,
  ItemPerPage,
  PAGE,
  headers
)

#Crée le chemin d'export
try:
    os.makedirs(SAVE_PATH_IMG)
    os.makedirs(SAVE_PATH_JSON)
except :
    pass


JSON_HEROS = []
JSON_CARDS_COMMON = []
JSON_CARDS_RARE = []

#Debut du script - boucle sur le nombre de PAGE
for runPage in range(1,PAGE):

    #Appel l'API
    response = requests.get(API_URL+'?cardSet[]='+SETNAME+'&ItemPerPage='+str(ItemPerPage)+'&page='+str(runPage), headers=headers)

    #Verifies si la connection à reussi
    if response.status_code == 200:

        # place la reponce de l'API dans un json
        jsonFile = json.loads(response.text)

        # Debut de la boucle pour recupéré tout les carte sur la PAGE numero "runPage"
        for runCarte in range(ItemPerPage):

            # test pour voir si arrivé à la dernier carte de la dernier page pour evité les erreur
            try:
                TypeCarte = (jsonFile['hydra:member'][runCarte]['cardType']['name'])
            except:
                # si erreur case la boucle
                break

            # exclue les jeton
            if TypeCarte != 'Jeton Personnage':

                # Place tout les info de la carte dans des variable
                # Numero de la carte
                NameJPG = (jsonFile['hydra:member'][runCarte]['collectorNumberFormatted'])
                # Code de reference
                ReferenceJPG = (jsonFile['hydra:member'][runCarte]['reference'])
                # Rarter de la carte (Commune,Rare,Out Of Faction)
                RarityJPG = (jsonFile['hydra:member'][runCarte]['rarity']['reference'])
                # Faction de la carte
                DataFaction = (jsonFile['hydra:member'][runCarte]['mainFaction']['reference'])
                # Nom de la carte
                DataName = (jsonFile['hydra:member'][runCarte]['name'])
                # Cout mana depuit la main
                DataMain = (jsonFile['hydra:member'][runCarte]['elements']['MAIN_COST'])
                if DataMain[0] == '#':
                    DataMain = DataMain[1]
                # Cout en mana depuit la reserve
                DataRecall = (jsonFile['hydra:member'][runCarte]['elements']['RECALL_COST'])
                if DataRecall[0] == '#':
                    DataRecall = DataRecall[1]
                # Variable de terrain
                #DataName = (jsonFile['hydra:member'][runCarte]['elements']['OCEAN_POWER'])
                #DataName = (jsonFile['hydra:member'][runCarte]['elements']['FOREST_POWER'])
                #DataName = (jsonFile['hydra:member'][runCarte]['elements']['MOUNTAIN_POWER'])

                # Lien de image png
                LinkJPG = (jsonFile['hydra:member'][runCarte]['imagePath'])
                # Requet le lien de l'image
                responseJPG = requests.get(LinkJPG,allow_redirects=True)

                # Si carte hero ajouter à la variable d'export json pour hero
                if TypeCarte == 'Héros':
                    JSON_HEROS.append([NameJPG,DataFaction,DataName,DataMain,DataRecall,ReferenceJPG])

                # Si carte n'est pas hero ajouter à la variable d'export json pour les non hero
                else:
                    # Si carte commune ajouter à la variable d'export json pour commune
                    if RarityJPG == 'COMMON':
                        JSON_CARDS_COMMON.append([NameJPG,DataFaction,DataName,DataMain,DataRecall,ReferenceJPG])
                    # Si carte non commune ajouter à la variable d'export json pour carte rare et oof
                    else:
                        JSON_CARDS_RARE.append([NameJPG,DataFaction,DataName,DataMain,DataRecall,ReferenceJPG])

                # Si lien image fonctionne télècharge les image
                if responseJPG.status_code == 200:
                    with open(SAVE_PATH_IMG+NameJPG+".png", 'wb') as f:
                        f.write(responseJPG.content)

            #ici fin de la boucle carte pass a la suivante de la page
    #ici fin de la boucle page pass a la suivante ou fin de script

# Crée les 3 json
with open(SAVE_PATH_JSON+"heros.json", 'w') as h:
    # Formatage et mise dans le json
    json.dump(JSON_HEROS,h)
with open(SAVE_PATH_JSON+"common.json", 'w') as c:
    # Formatage et mise dans le json
    json.dump(JSON_CARDS_COMMON,c)
with open(SAVE_PATH_JSON+"rare.json", 'w') as r:
    # Formatage et mise dans le json
    json.dump(JSON_CARDS_RARE,r)