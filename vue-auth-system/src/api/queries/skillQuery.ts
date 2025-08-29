import { gql } from '@apollo/client/core';
import { gqlClient } from '../gql/client';

// =====================
// GraphQL Queries
// =====================

export const GET_SKILLS = gql`
  query GetSkills {
    skills {
      id
      name
      level
      icon
      category {
        id
        name
      }
      created_at
      updated_at
    }
  }
`;

export const GET_SKILL = gql`
  query GetSkill($id: ID!) {
    skill(id: $id) {
      id
      name
      level
      icon
      category {
        id
        name
      }
      created_at
      updated_at
    }
  }
`;

// =====================
// Functions
// =====================

export async function getSkills(): Promise<any[]> {
  try {
    const { data } = await gqlClient.query({
      query: GET_SKILLS,
      fetchPolicy: 'no-cache', // optional: disables caching
    });
    return Array.isArray(data.skills) ? data.skills : [];
  } catch (err) {
    console.error('Error fetching skills:', err);
    return [];
  }
}

export async function getSkill(id: number | string): Promise<any | null> {
  try {
    const { data } = await gqlClient.query({
      query: GET_SKILL,
      variables: { id },
      fetchPolicy: 'no-cache',
    });
    return data.skill ?? null;
  } catch (err) {
    console.error(`Error fetching skill ${id}:`, err);
    return null;
  }
}
