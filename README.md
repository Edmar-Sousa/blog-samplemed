# como executar

```
# tab 1
git clone https://github.com/Edmar-Sousa/blog-samplemed.git

cd blog-samplemed/backend
./bin/cake migrations migrate
./bin/cake migrations seed --seed UsersSeed
./bin/cake server

composer install


# tab 2
cd blog-samplemed/fronend

npm install
npm run dev

# usuario de teste
# email: usuariopadrao@gmail.com
# senha: 123

```

# To-Do
- [ ] mover a logica de UserController para dentro de UserServices
- [x] mover a logica de ArticleController para dentro de ArticleService
- [ ] criar controller de Commentarios
- [ ] Pagina de cadastrar um Artigo
- [ ] Pagina de editar perfil
- [ ] Pagina de registro
