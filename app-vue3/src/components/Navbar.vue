<template>
  <nav>
    <div>
      <h1 class="main-title">DAVID<span class="main-title-span">M</span></h1>
    </div>
    <div class="navbar-links">
      <RouterLink class="menu-links" to="/">Home</RouterLink>
      <RouterLink class="menu-links" to="/register">Register</RouterLink>
    </div>
  </nav>
</template>

<script setup></script>

<style>
nav {
  padding: 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: #222;
}

@media (max-width: 630px) {
  nav .navbar-links {
    display: none;
  }
}

.main-title {
  color: #fff;
}

.main-title-span {
  font-weight: 700;
  color: hsla(160, 100%, 37%, 1);
}

.menu-links {
  position: relative;
  text-transform: uppercase;
}

.menu-links::after {
  content: ' ';
  padding: px;
  width: 0%;
  background-color: hsla(160, 100%, 37%, 1);
  position: absolute;
  bottom: 0;
  left: 0;
  transition: 0.5s ease-in-out;
}

.menu-links:hover::after {
  padding: 1px;
  width: 100%;
}
</style>
