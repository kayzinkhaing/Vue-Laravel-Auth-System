export interface Skill {
  id: number
  _id: string
  name: string
  level: number
  color?: string
  icon?: string | null
  category?: {
    id: number
    name: string
  }
}

export interface SkillCategory {
  id: number
  title: string
  iconClass: string
  skills: Skill[]
}

export interface Highlight {
  title: string
  icon: string
  iconClass: string
  description: string
}
