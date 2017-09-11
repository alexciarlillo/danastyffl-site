## About

A Laravel & VueJS application that acts as a landing page for a fantasy league hosted on MFL. Uses the MFL API to fetch team standings by year, and other dynasty relevant information. Uses a custom auth provider which authenticates users against the MFL site, allowing the application to initiate actions on the user's behalf.

## Implementation

* Laravel
  * Custom authentication user provider based on the MFL API and cookies.
  * Guzzle HTTP Client to fetch API data.
  * Cached API responses.
  * Custom API endpoints for the front-end.
* VueJS
  * vue-router based routing
  * Standings component for sorted league standings by year.
  * Scores component for tracking weekly scores by matchup

## TODO

* Link to player rosters
* Ability to initiate trades
* Scoring
  * Swipe to change matchup
  * Game Info (opposing team, final, score, remaining mins)
