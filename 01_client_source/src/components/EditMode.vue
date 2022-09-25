<template>
  <div class="edit-mode">
    <nav>
      <button @click="$emit('viewMode')">View mode</button>
      <button @click="$emit('clear')">Clear</button>
    </nav>
    <div class="area">
      <svg>
        <line :x1="link.x1" :x2="link.x2" :y1="link.y1" :y2="link.y2" v-for="link in links" :key="link.id" :class="{selected: link.selected}" @click="selectLink(link)"></line>
      </svg>
      <div class="elements">
        <EditModeElement v-for="element in elements" :key="element.id" :element="element" @deleteElement="$emit('deleteElement', element)" @createLinkedElement="createLinkedElement($event, element)" @linking="linking($event, element)" @movestart="movestart($event, element)" @selectElement="selectElement(element)"></EditModeElement>
      </div>
    </div>
    <div class="panel" v-show="selectedElement.id">
      <p>
        <label>Title</label>
        <input type="text" v-model="selectedElement.title">
      </p>
      <p>
        <textarea id="editor"></textarea>
      </p>
      <template v-for="node in selectedElement.nodes" :key="node.id">
        <p v-if="node.linkId">
          <label>Node {{ node.id }}</label>
          <input type="text" v-model="node.title">
        </p>
      </template>
    </div>
  </div>
</template>

<script>
import EditModeElement from "./EditModeElement.vue";

export default {
  name: 'EditMode',
  props: ['elements', 'links'],
  components: {
    EditModeElement
  },
  data() {
    return {
      draggingElement: null,
      draggingState: false,
      startOffset: {x: 0, y: 0},
      linkingState: {from: {element: null, node: null}, to: {element: null, node: null}}
    }
  },
  watch: {
    selectedElement: function () {
      window.CKEDITOR.instances.editor.setData(this.selectedElement.content || '')
    }
  },
  computed: {
    selectedElement: function () {
      return this.elements.find(v => v.selected) || {}
    }
  },
  methods: {
    createLinkedElement: function (node, element) {
      if (this.draggingState) return
      this.$emit('createLinkedElement', element, node)
    },
    linking: function (node, element) {
      if (this.draggingState) return
      if (!this.linkingState.from.element) {
        this.linkingState.from = {
          element: element,
          node: node
        }
      }
      else {
        this.linkingState.to = {
          element: element,
          node: node
        }
      }
      node.linking = true
      if (this.linkingState.from.element && this.linkingState.to.element) {
        this.$emit('linkElements', this.linkingState)
        this.linkingState.from.node.linking = false
        this.linkingState.to.node.linking = false
        this.linkingState = {from: {element: null, node: null}, to: {element: null, node: null}}
      }
    },
    movestart: function (e, element) {
      this.draggingElement = element
      this.startOffset = {
        x: e.x - element.x,
        y: e.y - element.y,
      }
    },
    move: function (e) {
      if (!this.draggingElement) return
      this.draggingState = true
      this.draggingElement.x = e.x - this.startOffset.x
      this.draggingElement.y = e.y - this.startOffset.y
    },
    moveend: function () {
      this.draggingElement = null
      this.draggingState = false
    },
    isWysiwygareaAvailable: function() {
      if ( window.CKEDITOR.revision == ( '%RE' + 'V%' ) ) {
        return true;
      }
      return !!window.CKEDITOR.plugins.get( 'wysiwygarea' );
    },
    updateElement: function (data) {
      this.selectedElement = Object.assign(this.selectedElement, data)
    },
    deselect: function () {
      this.elements.forEach(element => element.selected = false)
      this.links.forEach(link => link.selected = false)
    },
    selectElement: function (element) {
      this.deselect()
      element.selected = true
    },
    selectLink: function (link) {
      this.deselect()
      link.selected = true
    }
  },
  updated() {
    if (this.selectedElement.id)
      this.selectedElement.content = window.CKEDITOR.instances.editor.getData()
  },
  mounted() {
    document.onmousemove = e => this.move(e)
    document.onmouseup = this.moveend
    document.onkeydown = e => {
      if (e.key === 'Delete' || e.key === 'Backspace') {
        this.$emit('deleteLink')
      }
    }
    document.querySelector('svg').onclick = e => {
      if (e.target.nodeName !== 'line') {
        this.deselect()
      }
    }
    const editorElement = document.getElementById('editor')
    if ( this.isWysiwygareaAvailable() ) {
      !window.CKEDITOR.replace( 'editor', {
        removePlugins: ['easyimage', 'cloudservices']
      } );
    } else {
      editorElement.setAttribute( 'contenteditable', 'true' );
      !window.CKEDITOR.inline( 'editor', {
        removePlugins: ['easyimage', 'cloudservices']
      } );
    }
  }
}
</script>
<style>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}
.edit-mode {
  display: grid;
  grid-template-rows: auto 1fr;
  grid-template-columns: 4fr 1fr;
  height: 100vh;
}
nav {
  grid-column: 1 / 3;
  border-bottom: 1px solid #565656;
  padding: .5rem;
}
nav button {
  padding: .5rem;
  margin-right: 1rem;
}
svg {
  position: absolute;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
}
.area, .elements {
  position: relative;
}
.panel {
  padding: 1rem;
  border-left: 1px solid #565656;
}
.element {
  position: absolute;
  user-select: none;
}
.nodes {
  transform: rotate(45deg);
  width: 100px;
  height: 100px;
  border-radius: 50%;
  overflow: hidden;
  border: 2px solid #565656;
  display: grid;
  grid-template-areas:
      "node1 node2"
      "node4 node3";
}
.nodes span {
  transform: rotate(-45deg);
}
.node {
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}
.node.active {
  background: #dddddd;
}
.node-1 {
  grid-area: node1;
  border-right: 1px solid #565656;
  border-bottom: 1px solid #565656;
}
.node-2 {
  grid-area: node2;
  border-left: 1px solid #565656;
  border-bottom: 1px solid #565656;
}
.node-3 {
  grid-area: node3;
  border-left: 1px solid #565656;
  border-top: 1px solid #565656;
}
.node-4 {
  grid-area: node4;
  border-right: 1px solid #565656;
  border-top: 1px solid #565656;
}
.element button {
  padding: 0 .5rem;
}
.element .edit {
  position: absolute;
  top: 0;
  left: 0;
}
.element .delete {
  position: absolute;
  top: 0;
  right: 0;
}
.nodes.selected {
  border-color: blue;
}
.element:not(:hover) .node {
  border: none !important;
  background: #FFFFFF;
}
.element:not(:hover) button, .element:not(:hover) span {
  display: none;
}
line {
  cursor: pointer;
  stroke: #565656;
  stroke-width: 2px;
}
line.selected {
  stroke: blue;
}
p label {
  display: block;
  margin-bottom: .5rem;
}
input {
  display: block;
  width: 100%;
  padding: .5rem;
}
p {
  margin-bottom: 1rem;
}
</style>