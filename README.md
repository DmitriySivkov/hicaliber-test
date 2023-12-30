### Setup guide
docker is used as a local dev platform
<ul>
<li>The architecture contains two pieces - backend and frontend</li>
<li>backend's env variables are all persisted in env.example file</li>
<li>frontend also requires an env file - its variables are also persisted in env.example</li>
<li>to start backend: docker-compose up from root dir</li>
<li>to start frontend: npm run dev from /frontend dir</li>
<li>p.s frontend is not dockerized</li>
</ul>