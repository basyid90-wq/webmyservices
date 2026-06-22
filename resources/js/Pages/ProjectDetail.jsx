import { ArrowLeft, Globe, Calendar, ExternalLink } from 'lucide-react'
import { route } from '@/lib/ziggy'
import Layout from '@/components/Layout'
import Button from '@/components/ui/Button'

export default function ProjectDetail({ project }) {
  return (
    <Layout>
      <section className="pt-28 pb-24">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <a href={route('portfolio')} className="inline-flex items-center gap-2 text-gray-400 hover:text-white mb-8 transition-colors">
            <ArrowLeft className="w-4 h-4" />
            Back to Portfolio
          </a>

          {project.thumbnail && (
            <img
              src={`/storage/${project.thumbnail}`}
              alt={project.title}
              className="w-full rounded-xl mb-8 border border-white/10"
            />
          )}

          <div className="flex flex-wrap gap-2 mb-4">
            <span className="bg-indigo-600/20 text-indigo-400 text-xs font-medium px-3 py-1 rounded-full">{project.category}</span>
            {project.technologies?.map((tech) => (
              <span key={tech} className="bg-gray-800 text-gray-300 text-xs font-medium px-3 py-1 rounded-full">{tech}</span>
            ))}
          </div>

          <h1 className="text-3xl md:text-4xl font-bold text-white mb-4">{project.title}</h1>

          <div className="flex flex-wrap items-center gap-6 text-sm text-gray-400 mb-8">
            {project.client && (
              <span className="flex items-center gap-1.5">
                <Globe className="w-4 h-4" />
                Client: {project.client.name}
              </span>
            )}
            {project.completion_date && (
              <span className="flex items-center gap-1.5">
                <Calendar className="w-4 h-4" />
                {new Date(project.completion_date).getFullYear()}
              </span>
            )}
          </div>

          {project.description && (
            <div className="prose prose-invert max-w-none">
              <p className="text-gray-400 leading-relaxed">{project.description}</p>
            </div>
          )}

          <div className="mt-12 pt-8 border-t border-white/10 flex flex-wrap gap-4">
            {project.live_url && (
              <a href={project.live_url} target="_blank" rel="noopener noreferrer">
                <Button variant="primary">
                  <ExternalLink className="w-4 h-4" />
                  View Live Project
                </Button>
              </a>
            )}
            <a href={route('contact')}>
              <Button variant={project.live_url ? 'outline' : 'primary'}>Need a Project Like This?</Button>
            </a>
            <a href={route('portfolio')}>
              <Button variant="outline">View Other Projects</Button>
            </a>
          </div>
        </div>
      </section>
    </Layout>
  )
}
