<!-- src/pages/Portfolio/SkillsView.vue -->
<template>
<<<<<<< HEAD
  <section class="skills-view py-20 px-6 text-white">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <SectionTitle
        title="Technical Skills"
        subtitle="Technologies and tools I work with"
        class="mb-16"
      />

      <!-- Loading -->
      <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="n in 6" :key="n" class="glass-card p-8 animate-pulse h-40"></div>
      </div>

      <!-- Error -->
      <div v-else-if="error" class="text-center py-20">
        <p class="text-red-400">{{ error }}</p>
        <button
          @click="loadSkills"
          class="mt-4 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors"
        >
          Try Again
        </button>
      </div>

      <!-- No Skills -->
      <div v-else-if="skillCategories.length === 0" class="text-center py-20">
        <p class="text-slate-400">No skills found</p>
      </div>

      <!-- Skill Categories -->
      <div v-else class="space-y-12">
        <div
          v-for="category in skillCategories"
          :key="category.title"
          class="glass-card p-8"
        >
          <h3 class="text-2xl font-bold text-white mb-8 flex items-center">
            <span :class="category.iconClass" class="w-8 h-8 rounded mr-3"></span>
            {{ category.title }}
          </h3>
          <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <SkillBadge
              v-for="skill in category.skills"
              :key="skill.name"
              :name="skill.name"
              :level="skill.level"
              :color="skill.color"
            />
=======
  <div class="py-20 px-6 min-h-screen bg-gradient-to-br from-gray-900 via-blue-900/20 to-gray-900">
    <div class="max-w-7xl mx-auto">
      <SectionTitle 
        title="Skills & Abilities" 
        subtitle="My technical expertise across different domains"
        class="mb-16"
      />

      <!-- Skills Navigation -->
      <div class="flex flex-wrap justify-center gap-4 mb-12">
        <button
          v-for="category in skillCategories"
          :key="category.id"
          @click="activeCategory = category.id"
          :class="[
            'px-6 py-3 rounded-full font-medium transition-all duration-300',
            activeCategory === category.id 
              ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg' 
              : 'bg-gray-800/50 text-gray-300 hover:bg-gray-700/50 hover:text-white'
          ]"
        >
          <span class="mr-2">{{ category.icon }}</span>
          {{ category.title }}
        </button>
      </div>

      <!-- Active Category Display -->
      <div class="glass-card p-8 mb-12">
        <div class="text-center mb-8">
          <div :class="currentCategory.gradientClass" class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-3xl">{{ currentCategory.icon }}</span>
>>>>>>> 2e1134428b69e648105d8dc41d4515424c01eb25
          </div>
          <h2 class="text-3xl font-bold text-white mb-2">{{ currentCategory.title }}</h2>
          <p class="text-gray-300 max-w-2xl mx-auto">{{ currentCategory.description }}</p>
        </div>

        <!-- Skills Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
          <SkillCard
            v-for="skill in currentCategory.skills"
            :key="skill.name"
            :name="skill.name"
            :level="skill.level"
            :icon="skill.icon"
            :color="skill.color"
            :experience="skill.experience"
            :projects="skill.projects"
          />
        </div>
      </div>
<<<<<<< HEAD
=======

      <!-- Advanced Concepts Section -->
      <div v-if="currentCategory.advancedConcepts" class="glass-card p-8">
        <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
          <span class="bg-gradient-to-r from-pink-500 to-rose-500 w-8 h-8 rounded mr-3 flex items-center justify-center">
            🚀
          </span>
          Advanced Concepts & Best Practices
        </h3>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <ConceptCard
            v-for="concept in currentCategory.advancedConcepts"
            :key="concept.title"
            :title="concept.title"
            :description="concept.description"
            :examples="concept.examples"
            :useCase="concept.useCase"
          />
        </div>
      </div>
>>>>>>> 2e1134428b69e648105d8dc41d4515424c01eb25
    </div>
  </section>
</template>

<script setup lang="ts">
<<<<<<< HEAD
import { ref, onMounted } from "vue"
import SectionTitle from "@/components/portfolio/SectionTitle.vue"
import SkillBadge from "@/components/portfolio/SkillBadge.vue"
import { getSkills, getSkill } from "@/api/queries/skillQuery";
=======
import { ref, computed } from 'vue'
import SectionTitle from "@/components/portfolio/SectionTitle.vue"
import SkillCard from "@/components/portfolio/SkillCard.vue"
import ConceptCard from "@/components/portfolio/ConceptCard.vue"
>>>>>>> 2e1134428b69e648105d8dc41d4515424c01eb25

interface Skill {
  name: string
  level: number
  icon: string
  color: string
  experience: string
  projects?: number
}

interface AdvancedConcept {
  title: string
  description: string
  examples: string[]
  useCase: string
}

interface SkillCategory {
<<<<<<< HEAD
  title: string
  iconClass: string
  skills: Skill[]
}

const skillCategories = ref<SkillCategory[]>([])
const loading = ref(true)
const error = ref<string | null>(null)

function assignColor(skillName: string): string {
  const colors = ["blue", "green", "red", "orange", "purple", "cyan", "pink", "yellow", "indigo", "gray"]
  let hash = 0
  for (let i = 0; i < skillName.length; i++) hash += skillName.charCodeAt(i)
  return colors[hash % colors.length]
}

async function loadSkills() {
  loading.value = true
  error.value = null
  try {
    const skillsData = await getSkills()

    // Group skills by category
    const categoriesMap: Record<string, SkillCategory> = {}
    skillsData.forEach(skill => {
      const catTitle = skill.category?.name ?? "Uncategorized"
      if (!categoriesMap[catTitle]) {
        categoriesMap[catTitle] = {
          title: catTitle,
          iconClass: "bg-gradient-to-r from-blue-500 to-cyan-500",
          skills: []
        }
      }
      categoriesMap[catTitle].skills.push({
        name: skill.name,
        level: skill.level,
        color: assignColor(skill.name)
      })
    })

    skillCategories.value = Object.values(categoriesMap)
  } catch (err: any) {
    error.value = err.message || "Failed to load skills"
  } finally {
    loading.value = false
  }
}

onMounted(loadSkills)
=======
  id: string
  title: string
  icon: string
  gradientClass: string
  description: string
  skills: Skill[]
  advancedConcepts?: AdvancedConcept[]
}

const activeCategory = ref('frontend')

const skillCategories: SkillCategory[] = [
  {
    id: 'frontend',
    title: 'Frontend Development',
    icon: '💻',
    gradientClass: 'bg-gradient-to-r from-blue-500 to-cyan-500',
    description: 'Building responsive, interactive user interfaces with modern frameworks and best practices',
    skills: [
      { name: 'HTML5', level: 95, icon: '🟧', color: 'orange', experience: '3+ years', projects: 15 },
      { name: 'CSS3', level: 90, icon: '🔵', color: 'blue', experience: '3+ years', projects: 15 },
      { name: 'JavaScript', level: 85, icon: '🟨', color: 'yellow', experience: '2+ years', projects: 12 },
      { name: 'TypeScript', level: 80, icon: '🔷', color: 'blue', experience: '1+ years', projects: 8 },
      { name: 'Vue.js', level: 90, icon: '🟢', color: 'green', experience: '2+ years', projects: 10 },
      { name: 'React.js', level: 70, icon: '⚛️', color: 'blue', experience: '6+ months', projects: 3 },
      { name: 'TailwindCSS', level: 90, icon: '🎨', color: 'cyan', experience: '1+ years', projects: 8 },
      { name: 'Bootstrap', level: 85, icon: '🅱️', color: 'purple', experience: '2+ years', projects: 10 }
    ],
    advancedConcepts: [
      {
        title: 'Vue Router (Advanced Navigation)',
        description: 'Complex routing patterns with guards and dynamic routes',
        examples: ['Nested routes', 'Route guards', 'Code splitting', 'Scroll behavior'],
        useCase: 'When building SPAs with authentication and protected routes'
      },
      {
        title: 'TypeScript with Vue',
        description: 'Type-safe Vue development with advanced TypeScript features',
        examples: ['Generic components', 'Typed props/emits', 'Store typing', 'Strict type checking'],
        useCase: 'Large applications requiring maintainability and error prevention'
      },
      {
        title: 'Component Composition',
        description: 'Advanced component patterns and reusability strategies',
        examples: ['Composables', 'Provide/Inject', 'Slots', 'Dynamic components'],
        useCase: 'Building scalable, maintainable component libraries'
      }
    ]
  },
  {
    id: 'backend',
    title: 'Backend Development',
    icon: '⚙️',
    gradientClass: 'bg-gradient-to-r from-green-500 to-emerald-500',
    description: 'Server-side development, APIs, and database management with robust architecture',
    skills: [
      { name: 'PHP', level: 90, icon: '🐘', color: 'indigo', experience: '3+ years', projects: 12 },
      { name: 'Laravel', level: 95, icon: '🔴', color: 'red', experience: '2+ years', projects: 10 },
      { name: 'Node.js', level: 75, icon: '🟢', color: 'green', experience: '1+ years', projects: 5 },
      { name: 'Express.js', level: 70, icon: '⚡', color: 'gray', experience: '1+ years', projects: 4 },
      { name: 'RESTful APIs', level: 90, icon: '🔗', color: 'blue', experience: '2+ years', projects: 8 },
      { name: 'GraphQL', level: 60, icon: '🟣', color: 'pink', experience: '6+ months', projects: 2 },
      { name: 'Livewire', level: 80, icon: '⚡', color: 'pink', experience: '1+ years', projects: 6 },
      { name: 'Microservices', level: 65, icon: '🔧', color: 'purple', experience: '6+ months', projects: 2 }
    ],
    advancedConcepts: [
      {
        title: 'API Design Patterns',
        description: 'RESTful principles, GraphQL schemas, and API versioning strategies',
        examples: ['Resource-based URLs', 'HTTP status codes', 'Rate limiting', 'API documentation'],
        useCase: 'Building scalable, maintainable APIs for mobile and web applications'
      },
      {
        title: 'Database Optimization',
        description: 'Query optimization, indexing strategies, and database design patterns',
        examples: ['Query optimization', 'Database indexing', 'Relationship design', 'Migration strategies'],
        useCase: 'High-performance applications with complex data relationships'
      },
      {
        title: 'Authentication & Security',
        description: 'JWT tokens, OAuth, session management, and security best practices',
        examples: ['JWT implementation', 'OAuth flows', 'CSRF protection', 'Input validation'],
        useCase: 'Secure applications with user authentication and authorization'
      }
    ]
  },
  {
    id: 'database',
    title: 'Database & Data',
    icon: '🗄️',
    gradientClass: 'bg-gradient-to-r from-purple-500 to-pink-500',
    description: 'Database design, optimization, and data management across different systems',
    skills: [
      { name: 'MySQL', level: 85, icon: '🐬', color: 'orange', experience: '3+ years', projects: 12 },
      { name: 'PostgreSQL', level: 75, icon: '🐘', color: 'blue', experience: '1+ years', projects: 4 },
      { name: 'MongoDB', level: 70, icon: '🍃', color: 'green', experience: '1+ years', projects: 3 },
      { name: 'Redis', level: 80, icon: '🔴', color: 'red', experience: '1+ years', projects: 5 },
      { name: 'Firebase', level: 75, icon: '🔥', color: 'yellow', experience: '1+ years', projects: 4 },
      { name: 'SQL', level: 90, icon: '📊', color: 'blue', experience: '3+ years', projects: 12 },
      { name: 'Database Design', level: 85, icon: '🏗️', color: 'purple', experience: '2+ years', projects: 8 },
      { name: 'Data Modeling', level: 80, icon: '📐', color: 'cyan', experience: '2+ years', projects: 6 }
    ]
  },
  {
    id: 'algorithms',
    title: 'Data Structures & Algorithms',
    icon: '🧮',
    gradientClass: 'bg-gradient-to-r from-orange-500 to-red-500',
    description: 'Problem-solving with efficient algorithms and optimal data structure selection',
    skills: [
      { name: 'Arrays & Strings', level: 90, icon: '📝', color: 'blue', experience: '3+ years', projects: 20 },
      { name: 'Linked Lists', level: 85, icon: '🔗', color: 'green', experience: '2+ years', projects: 15 },
      { name: 'Trees & Graphs', level: 80, icon: '🌳', color: 'green', experience: '2+ years', projects: 12 },
      { name: 'Hash Tables', level: 85, icon: '#️⃣', color: 'purple', experience: '2+ years', projects: 10 },
      { name: 'Sorting Algorithms', level: 90, icon: '↕️', color: 'orange', experience: '3+ years', projects: 18 },
      { name: 'Dynamic Programming', level: 75, icon: '🔄', color: 'cyan', experience: '1+ years', projects: 8 },
      { name: 'Big O Analysis', level: 85, icon: '📈', color: 'red', experience: '2+ years', projects: 15 },
      { name: 'Problem Solving', level: 90, icon: '🧩', color: 'pink', experience: '3+ years', projects: 25 }
    ]
  },
  {
    id: 'devops',
    title: 'DevOps & Deployment',
    icon: '🚀',
    gradientClass: 'bg-gradient-to-r from-indigo-500 to-blue-500',
    description: 'Infrastructure management, CI/CD pipelines, and deployment automation',
    skills: [
      { name: 'Git', level: 90, icon: '📚', color: 'orange', experience: '3+ years', projects: 20 },
      { name: 'GitHub Actions', level: 80, icon: '⚡', color: 'gray', experience: '1+ years', projects: 6 },
      { name: 'Docker', level: 75, icon: '🐳', color: 'blue', experience: '1+ years', projects: 5 },
      { name: 'CI/CD', level: 80, icon: '🔄', color: 'green', experience: '1+ years', projects: 6 },
      { name: 'DigitalOcean', level: 75, icon: '🌊', color: 'blue', experience: '1+ years', projects: 4 },
      { name: 'Nginx', level: 70, icon: '🟢', color: 'green', experience: '1+ years', projects: 3 },
      { name: 'Linux', level: 75, icon: '🐧', color: 'gray', experience: '1+ years', projects: 5 },
      { name: 'AWS', level: 60, icon: '☁️', color: 'orange', experience: '6+ months', projects: 2 }
    ]
  },
  {
    id: 'tools',
    title: 'Development Tools',
    icon: '🛠️',
    gradientClass: 'bg-gradient-to-r from-yellow-500 to-orange-500',
    description: 'Essential tools and utilities that enhance development productivity',
    skills: [
      { name: 'VS Code', level: 95, icon: '💙', color: 'blue', experience: '3+ years', projects: 25 },
      { name: 'Postman', level: 85, icon: '📮', color: 'orange', experience: '2+ years', projects: 12 },
      { name: 'Figma', level: 70, icon: '🎨', color: 'purple', experience: '1+ years', projects: 8 },
      { name: 'Chrome DevTools', level: 90, icon: '🔍', color: 'blue', experience: '3+ years', projects: 20 },
      { name: 'Terminal/CLI', level: 85, icon: '⌨️', color: 'gray', experience: '2+ years', projects: 15 },
      { name: 'NPM/Yarn', level: 85, icon: '📦', color: 'red', experience: '2+ years', projects: 12 },
      { name: 'Webpack/Vite', level: 80, icon: '⚡', color: 'purple', experience: '1+ years', projects: 8 },
      { name: 'ESLint/Prettier', level: 85, icon: '✨', color: 'green', experience: '2+ years', projects: 10 }
    ]
  }
]

const currentCategory = computed(() => 
  skillCategories.find(cat => cat.id === activeCategory.value) || skillCategories[0]
)
>>>>>>> 2e1134428b69e648105d8dc41d4515424c01eb25
</script>

<style scoped>
.glass-card {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.1);
<<<<<<< HEAD
  border-radius: 1rem;
}
</style>
=======
  border-radius: 20px;
}
</style>
>>>>>>> 2e1134428b69e648105d8dc41d4515424c01eb25
