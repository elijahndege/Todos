

<template>
  <div class="page-content page-container" id="page-content">
    <div class="padding">
      <div class="row container d-flex justify-content-center">
        <div class="col-lg-12">
          <div class="card px-3">
            <div class="card-body">
              <h4 class="card-title">Todo list</h4>
              <div class="add-items d-flex">
                <input
                  @keyup.enter="addTask"
                  v-model="newTask"
                  type="text"
                  class="form-control todo-list-input"
                  placeholder="What do you need to do today?"
                />
                <button
                  @click="addTask"
                  :disabled="newTask.length === 0"
                  class="add btn btn-primary font-weight-bold todo-list-add-btn"
                >Add</button>
              </div>
              <div class="list-wrapper">
                <ul class="d-flex flex-column-reverse todo-list">
                  <li v-for="task in tasks" :key="task.id">
                    <div class="form-check" :class="{completed: task.is_completed}">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox" v-model="task.is_completed"/>
                        {{task.task}}
                        <i class="input-helper"></i>
                      </label>
                    </div>
                    <i @click.prevent="destroy(task.id)" class="remove fa fa-trash"></i>
                  </li>
                </ul>
              </div>
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
      newTask: "",
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
    // showEditForm(task) {
    //   this.newTask.edit = true;
    //   console.log(this.newTask.task);
    // },

    addTask() {
      if (this.newTask.length > 0) {
        let task = {
          task: this.newTask,
          is_completed: true
        };
        let uri = "https://crud.test/api/todos/store";
        this.axios
          .post(uri, task)
          .then(response => {
            this.tasks.push(response.data.data);
            this.newTask = "";
          })
          .catch(error => {
            this.validation = error.response.data.data;
          });
      }
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