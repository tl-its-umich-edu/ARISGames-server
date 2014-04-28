var CRUD_DEFAULTS = [
{
    "service":"",
    "create":"",
    "get":"",
    "update":"",
    "delete":"",
    "createData":"",
    "getData":"",
    "updateData":"",
    "deleteData":""
},
{
    "service":"games",
    "create":"games.createGameJSON",
    "get":"games.getGame",
    "update":"games.updateGameJSON",
    "delete":"games.deleteGame",
    "createData":
        '\
        {\n\
          "name":"gameName",\n\
          "description":"gameDescription",\n\
          "icon_media_id":1,\n\
          "media_id":2,\n\
          "map_type":"huh",\n\
          "latitude":1.234,\n\
          "longitude":2.468,\n\
          "zoom_level":2,\n\
          "show_player_location":true\n\
        }\n\
        ',
    "getData":"123",
    "updateData":
        '\
        {\n\
          "game_id":123,\n\
          "name":"gameName",\n\
          "description":"gameDescription",\n\
          "icon_media_id":1,\n\
          "media_id":2,\n\
          "map_type":"huh",\n\
          "latitude":1.234,\n\
          "longitude":2.468,\n\
          "zoom_level":2,\n\
          "show_player_location":true\n\
        }\n\
        ',
    "deleteData":"123"
},
{
    "service":"requirements",
    "create":"requirements.createRequirementPackageJSON",
    "get":"requirements.getRequirementPackage",
    "update":"requirements.updateRequirementPackageJSON",
    "delete":"requirements.deleteRequirementPackage",
    "createData":
        '\
        {\n\
          "game_id":123,\n\
          "name":"requirementPackageName",\n\
          "and_packages": [\n\
            {\n\
              "name":"andPackageName",\n\
              "atoms": [\n\
                {\n\
                  "bool_operator":0,\n\
                  "requirement":"PLAYER_HAS_ITEM",\n\
                  "content_id":1,\n\
                  "qty":4,\n\
                  "latitude":86.75309,\n\
                  "longitude":3.141592\n\
                },\n\
                {\n\
                  "bool_operator":1,\n\
                  "requirement":"PLAYER_HAS_ITEM",\n\
                  "content_id":2,\n\
                  "qty":3,\n\
                  "latitude":86.75309,\n\
                  "longitude":3.141592\n\
                }\n\
              ]\n\
            },\n\
            {\n\
              "name":"andPackageName2",\n\
              "atoms": [\n\
                {\n\
                  "bool_operator":0,\n\
                  "requirement":"PLAYER_HAS_ITEM",\n\
                  "content_id":1,\n\
                  "qty":4,\n\
                  "latitude":86.75309,\n\
                  "longitude":3.141592\n\
                },\n\
                {\n\
                  "bool_operator":1,\n\
                  "requirement":"PLAYER_HAS_ITEM",\n\
                  "content_id":2,\n\
                  "qty":3,\n\
                  "latitude":86.75309,\n\
                  "longitude":3.141592\n\
                }\n\
              ]\n\
            }\n\
          ]\n\
        }\n\
        ',
    "getData":"123",
    "updateData":
        '\
        {\n\
          "requirement_root_package_id":123,\n\
          "name":"requirementPackageName",\n\
          "and_packages": [\n\
            {\n\
              "requirement_and_package_id":234,\n\
              "name":"andPackageName",\n\
              "atoms": [\n\
                {\n\
                  "requirement_atom_id":234,\n\
                  "bool_operator":0,\n\
                  "requirement":"PLAYER_HAS_ITEM",\n\
                  "content_id":1,\n\
                  "qty":4,\n\
                  "latitude":86.75309,\n\
                  "longitude":3.141592\n\
                },\n\
                {\n\
                  "requirement_atom_id":235,\n\
                  "bool_operator":1,\n\
                  "requirement":"PLAYER_HAS_ITEM",\n\
                  "content_id":2,\n\
                  "qty":3,\n\
                  "latitude":86.75309,\n\
                  "longitude":3.141592\n\
                }\n\
              ]\n\
            },\n\
            {\n\
              "requirement_and_package_id":235,\n\
              "name":"andPackageName2",\n\
              "atoms": [\n\
                {\n\
                  "requirement_atom_id":236,\n\
                  "bool_operator":0,\n\
                  "requirement":"PLAYER_HAS_ITEM",\n\
                  "content_id":1,\n\
                  "qty":4,\n\
                  "latitude":86.75309,\n\
                  "longitude":3.141592\n\
                },\n\
                {\n\
                  "requirement_atom_id":237,\n\
                  "bool_operator":1,\n\
                  "requirement":"PLAYER_HAS_ITEM",\n\
                  "content_id":2,\n\
                  "qty":3,\n\
                  "latitude":86.75309,\n\
                  "longitude":3.141592\n\
                }\n\
              ]\n\
            }\n\
          ]\n\
        }\n\
        ',
    "deleteData":"123"
},
{
    "service":"scenes",
    "create":"scenes.createSceneJSON",
    "get":"scenes.getScene",
    "update":"scenes.updateSceneJSON",
    "delete":"scenes.deleteScene",
    "createData":
        '\
        {\n\
          "game_id":123,\n\
          "name":"sceneName"\n\
        }\n\
        ',
    "getData":"123",
    "updateData":
        '\
        {\n\
          "scene_id":234,\n\
          "name":"sceneName"\n\
        }\n\
        ',
    "deleteData":"123"
},
{
    "service":"triggers",
    "create":"triggers.createTriggerJSON",
    "get":"triggers.getTrigger",
    "update":"triggers.updateTriggerJSON",
    "delete":"triggers.deleteTrigger",
    "createData":
        '\
        {\n\
          "game_id":123,\n\
          "name":"triggerName",\n\
          "instance_id":123,\n\
          "scene_id":123,\n\
          "requirement_root_package_id":132,\n\
          "type":"LOCATION",\n\
          "latitude":1.234,\n\
          "longitude":2.468,\n\
          "distance":5,\n\
          "wiggle":1,\n\
          "show_title":1,\n\
          "code":"abc123"\n\
        }\n\
        ',
    "getData":"123",
    "updateData":
        '\
        {\n\
          "trigger_id":123,\n\
          "name":"triggerName",\n\
          "instance_id":123,\n\
          "scene_id":123,\n\
          "requirement_root_package_id":132,\n\
          "type":"LOCATION",\n\
          "latitude":1.234,\n\
          "longitude":2.468,\n\
          "distance":5,\n\
          "wiggle":1,\n\
          "show_title":1,\n\
          "code":"abc123"\n\
        }\n\
        ',
    "deleteData":"123"
},
{
    "service":"instances",
    "create":"instances.createInstanceJSON",
    "get":"instances.getInstance",
    "update":"instances.updateInstanceJSON",
    "delete":"instances.deleteInstance",
    "createData":
        '\
        {\n\
          "game_id":123,\n\
          "object_id":123,\n\
          "object_type":"PLAQUE",\n\
          "spawnable_id":123\n\
        }\n\
        ',
    "getData":"123",
    "updateData":
        '\
        {\n\
          "instance_id":123,\n\
          "object_id":123,\n\
          "object_type":"PLAQUE",\n\
          "spawnable_id":123\n\
        }\n\
        ',
    "deleteData":"123"
},
{
    "service":"items",
    "create":"items.createItemJSON",
    "get":"items.getItem",
    "update":"items.updateItemJSON",
    "delete":"items.deleteItem",
    "createData":
        '\
        {\n\
          "game_id":123,\n\
          "name":"itemName",\n\
          "description":"itemDescription",\n\
          "icon_media_id":123,\n\
          "media_id":123,\n\
          "droppable":1,\n\
          "destroyable":1,\n\
          "max_qty_in_inventory":500,\n\
          "weight":0,\n\
          "url":"http://www.arisgames.org",\n\
          "type":"NORMAL"\n\
        }\n\
        ',
    "getData":"123",
    "updateData":
        '\
        {\n\
          "item_id":123,\n\
          "name":"itemName",\n\
          "description":"itemDescription",\n\
          "icon_media_id":123,\n\
          "media_id":123,\n\
          "droppable":1,\n\
          "destroyable":1,\n\
          "max_qty_in_inventory":500,\n\
          "weight":0,\n\
          "url":"http://www.arisgames.org",\n\
          "type":"NORMAL"\n\
        }\n\
        ',
    "deleteData":"123"
},
{
    "service":"plaques",
    "create":"plaques.createPlaqueJSON",
    "get":"plaques.getPlaque",
    "update":"plaques.updatePlaqueJSON",
    "delete":"plaques.deletePlaque",
    "createData":
        '\
        {\n\
          "game_id":123,\n\
          "name":"plaqueName",\n\
          "description":"plaqueDescription",\n\
          "icon_media_id":123,\n\
          "media_id":123\n\
        }\n\
        ',
    "getData":"123",
    "updateData":
        '\
        {\n\
          "plaque_id":123,\n\
          "name":"plaqueName",\n\
          "description":"plaqueDescription",\n\
          "icon_media_id":123,\n\
          "media_id":123\n\
        }\n\
        ',
    "deleteData":"123"
},
{
    "service":"media",
    "create":"media.createMediaJSON",
    "get":"media.getMedia",
    "update":"media.updateMediaJSON",
    "delete":"media.deleteMedia",
    "createData":
        '\
        {\n\
          "game_id":123,\n\
          "display_name":"smiley",\n\
          "file_name":"smiley.png",\n\
          "data":"iVBORw0KGgoAAAANSUhEUgAAABQAAAAUBAMAAAB/pwA+AAAAA3NCSVQICAjb4U/gAAAAMFBMVEX/////7AD/4gD/2QD/zAD/xQD/vAD/sgD/qQA8/wCZmZnAlACceAA/Pz9AMQAAAADauoGxAAAAEHRSTlP///////////8A////////Xxf4pAAAAAlwSFlzAAAK8AAACvABQqw0mAAAAAh0RVh0Q29tbWVudAD2zJa/AAAAIXRFWHRTb2Z0d2FyZQBNYWNyb21lZGlhIEZpcmV3b3JrcyAzLjDvaTHwAAAAnElEQVR4nGOYCQcMQDz///+fEOb87+Xl9T/BzP9laWlp/0HM+eX/Q0P/p/8EMn+U7f7ivzusHsj8nv3f2Pj/1vyZDPPb/zsrKSkDVTDM7091VhRUdv0OZLaf/w8Ef0Ci7fkMQHAVnZm9gIGBayuQCTT3FwPDerC5P8rz3/9/mg5izm8HuaEcZPHMH+3l5eX9EEf+6Ojo/4nudBgAAKTFdNGCgV+fAAAAAElFTkSuQmCC"\n\
        }\n\
        ',
    "getData":"123",
    "updateData":
        '\
        {\n\
          "media_id":123,\n\
          "display_name":"smiley"\n\
        }\n\
        ',
    "deleteData":"123"
}
];
