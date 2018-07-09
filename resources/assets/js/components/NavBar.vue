<template>
  <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
    <router-link to="/standings" class="navbar-brand">
      <img src="images/team-logo.png" class="d-inline-block align-top" height="40" width="40">
      <span class="title ml-2">DaNasty FFL</span>
    </router-link>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>    

    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <router-link to="/standings" class="nav-link">Standings</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/scores" class="nav-link">Scores</router-link>
        </li>
      </ul>

      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="/mfl" class="nav-link">MFL</a>
        </li>
        <li class="nav-item">
          <a href="/login" class="nav-link">Login</a>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
    export default {
        name: 'NavBar',
    }
</script>
