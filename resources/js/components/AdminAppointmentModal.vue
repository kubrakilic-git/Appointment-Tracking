
    <template>
      <Transition name="modal">
        <div  class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h3>custom header</h3>

              </div>
    
              <div class="modal-body">
                <slot name="body">default body</slot>
              </div>
    
              <div class="modal-footer">
                <slot name="footer">
                  default footer
                  <button
                    class="modal-default-button"
                    @click="$emit('close')"
                  >OK</button>
                </slot>
              </div>
            </div>
          </div>
        </div>
      </Transition>
    </template>


<script>
    export default {
   
    }
</script>
 