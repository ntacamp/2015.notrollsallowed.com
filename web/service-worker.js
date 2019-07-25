/*
 * @license
 * Your First PWA Codelab (https://g.co/codelabs/pwa)
 * Copyright 2019 Google Inc. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License
 */
'use strict';

// CODELAB: Update cache names any time any of the cached files change.
const CACHE_NAME = 'nta-cache-v1';

this.addEventListener('install', async function() {
    const cache = await caches.open(CACHE_NAME);
    cache.addAll([
        '/lt/timetable/1',
    ])
})

self.addEventListener('fetch', event => {
    
    //We defind the promise (the async code block) that return either the cached response or the network one
    //It should return a response object
    const getCustomResponsePromise = async function() {
        
        try {

            //Here, we add the network response to the cache
            let cache = await caches.open(CACHE_NAME)

            return fetch(event.request)
            .then(function(response) {

                //We must provide a clone of the response here
                cache.put(event.request, response.clone())

                return response;
            })
            .catch(async function(response) {
                // return caches.match(event.request)

                const cachedResponse = await caches.match(event.request)

                if (cachedResponse) {
                    //Return the cached response if present
                    return cachedResponse
                } else {
                    return response;
                }
            })


        } catch (err) {

            console.error(`Error ${err}`)
            
            return fetch(event.request)

        }
    }

    //In order to override the default fetch behavior, we must provide the result of our custom behavoir to the
    //event.respondWith method
    event.respondWith(getCustomResponsePromise())
})
