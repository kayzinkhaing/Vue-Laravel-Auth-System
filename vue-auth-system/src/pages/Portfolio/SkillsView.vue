<template>
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
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue"
import SectionTitle from "@/components/portfolio/SectionTitle.vue"
import SkillBadge from "@/components/portfolio/SkillBadge.vue"
import { getSkills, getSkill } from "@/api/queries/skillQuery";

interface Skill {
  name: string
  level: number
  color: string
}

interface SkillCategory {
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
</script>

<style scoped>
.glass-card {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 1rem;
}
</style>
