import { gql } from '@apollo/client/core'

export const GET_PROJECTS = gql`
  query GetProjects {
    projects {
      id
      title
      slug
      description
      status {
        id
        name
      }
      start_date
      end_date
      is_featured
      technologies {
        id
        name
        slug
        icon
        created_at
        updated_at
      }
      updated_at
    }
  }
`

export const GET_PROJECT = gql`
  query GetProject($id: ID!) {
    project(id: $id) {
      id
      title
      slug
      description
      status {
        id
        name
      }
      start_date
      end_date
      is_featured
      technologies {
        id
        name
        slug
        icon
        created_at
        updated_at
      }
      created_at
      updated_at
    }
  }
`
import { gqlClient } from '../gql/client'
// import { GET_PROJECTS, GET_PROJECT } from './projectQueries'

export async function getProjects(): Promise<any[]> {
  try {
    const { data } = await gqlClient.query({
      query: GET_PROJECTS,
      fetchPolicy: 'no-cache', // optional: disables caching
    })
    return Array.isArray(data.projects) ? data.projects : []
  } catch (err) {
    console.error('Error fetching projects:', err)
    return []
  }
}

export async function getProject(id: number | string): Promise<any | null> {
  try {
    const { data } = await gqlClient.query({
      query: GET_PROJECT,
      variables: { id },
      fetchPolicy: 'no-cache',
    })
    return data.project ?? null
  } catch (err) {
    console.error(`Error fetching project ${id}:`, err)
    return null
  }
}
