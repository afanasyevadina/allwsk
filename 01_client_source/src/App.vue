<template>
  <main>
    <EditMode v-if="mode === 'edit'" :elements="elements" :links="links" @createLinkedElement="createLinkedElement" @deleteElement="deleteElement" @clear="clear" @linkElements="linkElements" @deleteLink="deleteLink" @viewMode="mode = 'view'"></EditMode>
    <ViewMode v-else :elements="elements" :links="links" @editMode="mode = 'edit'"></ViewMode>
  </main>
</template>

<script>
import EditMode from "./components/EditMode.vue";
import ViewMode from "./components/ViewMode.vue";

const SIZE = 100
const OFFSET = {
  1: {x: 0, y: -1 * SIZE * 1.5},
  2: {x: SIZE * 1.5, y: 0},
  3: {x: 0, y: SIZE * 1.5},
  4: {x: -1 * SIZE * 1.5, y: 0},
}
const LINKED = {
  1: 3,
  2: 4,
  3: 1,
  4: 2
}
const VERTICES = {
  1: {x: SIZE / 2, y: 0},
  2: {x: SIZE, y: SIZE / 2},
  3: {x: SIZE / 2, y: SIZE},
  4: {x: 0, y: SIZE / 2},
}

export default {
  name: 'App',
  components: {
    EditMode,
    ViewMode
  },
  data() {
    return {
      mode: 'edit',
      elements: [],
      links: []
    }
  },
  watch: {
    elements: {
      deep: true,
      handler: function () {
        this.links.forEach(link => {
          link.x1 = link.from.element.x + VERTICES[link.from.node.id].x
          link.y1 = link.from.element.y + VERTICES[link.from.node.id].y
          link.x2 = link.to.element.x + VERTICES[link.to.node.id].x
          link.y2 = link.to.element.y + VERTICES[link.to.node.id].y
        })
        localStorage.setItem('_elements_wsk1029', JSON.stringify(this.elements))
      }
    },
    links: {
      deep: true,
      handler: function () {
        this.elements.forEach(element => {
          element.nodes.forEach(node => {
            if (node.linkId && !this.links.find(v => v.id === node.linkId)) node.linkId = null
          })
        })
        localStorage.setItem('_links_wsk1029', JSON.stringify(this.links.map(link => ({
          id: link.id,
          from: {
            elementId: link.from.element.id,
            nodeId: link.from.node.id,
          },
          to: {
            elementId: link.to.element.id,
            nodeId: link.to.node.id,
          },
        }))))
      }
    }
  },
  methods: {
    createElement: function (options) {
      const area = document.querySelector('.area')
      let element = Object.assign({}, {
        id: Date.now(),
        title: 'Lorem ipsum',
        content: 'Lorem ipsum',
        x: (area ? area.clientWidth : window.innerWidth) / 2 - SIZE / 2,
        y: (area ? area.clientHeight : window.innerHeight) / 2 - SIZE / 2,
        selected: false,
        nodes: [
          {id: 1, linkId: null, title: 'Lorem ipsum'},
          {id: 2, linkId: null, title: 'Lorem ipsum'},
          {id: 3, linkId: null, title: 'Lorem ipsum'},
          {id: 4, linkId: null, title: 'Lorem ipsum'},
        ]
      }, options)
      this.elements.push(element)
      return element
    },
    createLink: function (fromElement, toElement, fromNode, toNode) {
      let link = {
        id: Date.now(),
        from: {
          element: fromElement,
          node: fromNode
        },
        to: {
          element: toElement,
          node: toNode
        },
      }
      fromNode.linkId = link.id
      toNode.linkId = link.id
      this.links.push(link)
      return link
    },
    createLinkedElement: function (element, node) {
      let linkedElement = this.createElement({
        x: element.x + OFFSET[node.id].x,
        y: element.y + OFFSET[node.id].y
      })
      this.createLink(element, linkedElement, node, linkedElement.nodes.find(v => v.id === LINKED[node.id]))
    },
    linkElements: function (linkingState) {
      this.createLink(linkingState.from.element, linkingState.to.element, linkingState.from.node, linkingState.to.node)
    },
    deleteElement: function (element) {
      element.nodes.forEach(node => {
        if (node.linkId) {
          this.links.splice(this.links.findIndex(v => v.id === node.linkId), 1)
        }
      })
      this.elements.splice(this.elements.findIndex(v => v.id === element.id), 1)
    },
    clear: function () {
      this.elements = []
      this.links = []
      this.createElement({selected: true})
    },
    deleteLink: function () {
      this.links = this.links.filter(link => !link.selected)
    }
  },
  mounted() {
    if (localStorage.getItem('_elements_wsk1029')) {
      this.elements = JSON.parse(localStorage.getItem('_elements_wsk1029')) || []
      this.links = (JSON.parse(localStorage.getItem('_links_wsk1029')) || []).map(link => {
        let from = this.elements.find(v => v.id === link.from.elementId)
        let to = this.elements.find(v => v.id === link.to.elementId)
        return {
          id: link.id,
          from: {
            element: from,
            node: from.nodes.find(v => v.id === link.from.nodeId)
          },
          to: {
            element: to,
            node: to.nodes.find(v => v.id === link.to.nodeId)
          }
        }
      })
    }
    this.$nextTick(() => {
      if (!this.elements.length) this.clear()
    })
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
}
</style>
