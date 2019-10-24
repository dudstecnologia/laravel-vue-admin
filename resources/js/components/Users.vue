<template>
<div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Usuários cadastrados</h3>

                <div class="card-tools">
                  <!-- <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div> -->
                  <button class="btn btn-success" data-toggle="modal" data-target="#addNew">Adicionar Novo <i class="fas fa-user-plus"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Criação</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>
                          <a href="http://">
                            <i class="fa fa-edit blue"/>
                          </a>
                            /
                          <a href="http://">
                            <i class="fa fa-trash red"/>
                          </a>
                      </td>
                    </tr> -->

                    <tr v-for="user in users.data" :key="user.id">
                      <td>{{ user.id }}</td>
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.type | upText }}</td>
                      <td>{{ user.created_at | dataFormatada }}</td>
                      <td>
                          <a href="http://">
                            <i class="fa fa-edit blue"/>
                          </a>
                            /
                          <a href="http://">
                            <i class="fa fa-trash red"/>
                          </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

    <!-- Modal -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Novo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="criarUsuario" @keydown="form.onKeydown($event)">
            <div class="modal-body">
                <div class="form-group">
                    <label>Nome</label>
                    <input v-model="form.name" type="text" name="name"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input v-model="form.email" type="text" name="email"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
                </div>
                <div class="form-group">
                    <label>Senha</label>
                    <input v-model="form.password" type="text" name="password"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                    <has-error :form="form" field="password"></has-error>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data () {
            return {
                users: [],
                form: new Form({
                    name: '',
                    email: '',
                    password: ''
                })
            }
        },
        created () {
            console.log('Componente criado');
            this.loadUsers();
        },
        methods: {
            loadUsers () {
                axios.get('api/user')
                    .then(({ data }) => ( this.users = data));
            },
            criarUsuario () {
                this.$Progress.start();
                // console.log("Teste");
                this.form.post('api/user')
                    .then( res => {
                        console.log("Ok");
                        console.log(res);

                        $('#addNew').modal('hide')

                        this.$Progress.finish();
                        toast.fire({
                            type: 'success',
                            title: 'Criado com sucesso'
                        })
                    })
                    .catch( err => {
                        console.log("Erro");
                        console.log(err);
                    });
            }
        }
    }
</script>
