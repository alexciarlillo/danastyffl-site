<template>
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">DaNasty FFL</a>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
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
