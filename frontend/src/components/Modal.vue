// https://adamwathan.me/2016/01/04/composing-reusable-modal-dialogs-with-vuejs/
<template>
  <transition name="modal">
    <div class="modal-mask" @click="close" v-show="show" >
      <div class="modal-wrapper">
        <div class="modal-container"  @click.stop>
          <header class="modal-header">
            <h2><slot name="header"></slot></h2>
          </header>
          
          <section class="modal-body">
            <slot name="body"></slot>
          </section>
          
          <footer class="modal-footer">
            <slot name="footer">
              <button class="btn_crud btn_close modal-default-button" @click="close" >
                <i class="fa fa-close"></i>
              </button>
            </slot>
          </footer>
          
        </div>
      </div>
    </div>
  </transition>
</template>

<script>

  export default {
    props: ['show', 'onClose'],
    methods: {
      close: function () {
          this.onClose();
      }
    },
  }
</script>

<style>

.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 300px;
  margin: 0px auto;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
}

.modal-header h2 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

.form-control {
    display: block;
    width: 100%;
    padding: 0.5em 1em;
    line-height: 1.5;
    border: 1px solid #ddd;
}

.modal-footer {
    align-items: center;
    display: flex;
    flex-shrink: 0;
    justify-content: flex-start;
    /*position: relative;*/
}


/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}

</style>