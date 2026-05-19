#!/bin/bash

URL="http://localhost:8000"

register_user () {
    ID=$1
    COOKIE="cookie_$ID.txt"

    PAGE=$(curl -s -c $COOKIE $URL/register)

    TOKEN=$(echo "$PAGE" | grep -oP 'name="_token"\s+value="\K[^"]+')

    curl -s -o /dev/null -w "User $ID => HTTP %{http_code}\n" \
      -b $COOKIE -c $COOKIE \
      -X POST $URL/register \
      -d "_token=$TOKEN" \
      -d "name=User$ID" \
      -d "email=user$ID@test.com" \
      -d "password=password123" \
      -d "password_confirmation=password123"

    rm -f $COOKIE
}

export -f register_user
export URL

seq 1 200 | xargs -I{} -P 100 bash -c 'register_user "$@"' _ {}
