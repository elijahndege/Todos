<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div v-if="!newTask.edit" class="card border-secondary">
          <div class="card-header">Add Task</div>
          <div class="card-body text-secondary">
            <form @submit.prevent="taskStore">
              <div class="form-group">
                <label>Task</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="newTask.task"
                  placeholder="Add Task"
                />
                <div v-if="validation.task">
                  <div class="alert alert-danger mt-1" role="alert">{{ validation.task[0] }}</div>
                </div>
              </div>

              <div class="form-group">
                <label>Description</label>
                <textarea
                  class="form-control"
                  v-model="newTask.description"
                  rows="5"
                  placeholder="Add task description"
                ></textarea>
                <div v-if="validation.description">
                  <div class="alert alert-danger mt-1" role="alert">{{ validation.description[0] }}</div>
                </div>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-md btn-success">Submit</button>
                <button type="reset" class="btn btn-md btn-danger">Reset</button>
              </div>
            </form>
          </div>
        </div>
        <div v-else class="card border-secondary">
          <div class="card-header">Edit Task</div>
          <div class="card-body text-secondary">
            <form @submit.prevent="UpdateStore">
              <div class="form-group">
                <label>Task</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="newTask.task"
                  placeholder="Add Task"
                />
                <div v-if="validation.task">
                  <div class="alert alert-danger mt-1" role="alert">{{ validation.task[0] }}</div>
                </div>
              </div>

              <div class="form-group">
                <label>Description</label>
                <textarea
                  class="form-control"
                  v-model="newTask.description"
                  rows="5"
                  placeholder="Add task description"
                ></textarea>
                <div v-if="validation.description">
                  <div class="alert alert-danger mt-1" role="alert">{{ validation.description[0] }}</div>
                </div>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-md btn-success">Submit</button>
                <button type="reset" class="btn btn-md btn-danger">Reset</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card card-success">
          <div class="card-header">Todos</div>

          <div class="card-body">
            <div class="table-responsive mt-2">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>Task</th>
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="task in tasks" :key="task.id">
                    <td>{{ task.task }}</td>
                    <td>{{ task.description }}</td>
                    <td class="text-center">
                      <button
                        @click.prevent="showEditForm(task)"
                        class="btn btn-sm btn-primary"
                      >Edit</button>
                      <button @click.prevent="destroy(task.id)" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  mounted() {
    this.fetchTodos();
  },
  data() {
    return {
      isLoading: true,
      newTask: {
        task:'',
        description:'',
        edit: false
      },
      tasks: [],
      validation: []
    };
  },
  methods: {
    async fetchTodos() {
      try {
        this.tasks = (
          await this.axios.get("https://crud.test/api/todos")
        ).data.data;
        console.log(this.tasks);
      } catch (e) {
        console.log(e);
        alert(e.error);
      }
      this.isLoading = false;
    },
    showEditForm(task) {
      this.newTask.edit = true;
     console.log(this.newTask.task);
    },

    taskStore() {
      let uri = "https://crud.test/api/todos/store";
      this.axios
        .post(uri, this.newTask)
        .then(response => {
          this.tasks.push(response.data.data);
        })
        .catch(error => {
          this.validation = error.response.data.data;
        });
    },
    destroy(id) {
      let uri = `https://crud.test/api/todos/${id}`;
      this.axios
        .delete(uri)
        .then(response => {
          this.tasks = this.tasks.filter(task => task.id !== id);
        })
        .catch(error => {
          alert("system error!");
        });
    }
  }
};
</script>