#!/usr/bin/python

import sys
import requests


def upload_keys(api_key, react_id, react_key, env):
    url = "https://api.doppler.com/v3/configs/config/secrets"

    payload = {
        "project": "mundotes-feria",
        "config": env,
        "secrets": {
            "REACT_APP_CLIENT_ID": react_id,
            "REACT_APP_CLIENT_SECRET": react_key,
        }
    }
    headers = {
        "Content-Type": "application/json",
        "api-key": api_key
    }

    response = requests.request("POST", url, json=payload, headers=headers)

    print(response.text)


upload_keys(sys.argv[1], sys.argv[2], sys.argv[3], sys.argv[4])

