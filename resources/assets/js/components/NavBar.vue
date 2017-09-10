<template>
  <nav class="navbar navbar-toggleable-md navbar-inverse bg-primary">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <router-link to="/standings" class="navbar-brand">DaNasty FFL</router-link>

    <div class="collapse navbar-collapse" id="navbarToggler">
      <ul class="navbar-nav mr-auto mt-2 mt-md-0">
        <li class="nav-item">
          <router-link to="/standings" class="nav-link">Standings</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/scores" class="nav-link">Scores</router-link>
        </li>
      </ul>

      <ul class="navbar-nav mt-2 mt-md-0">
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
