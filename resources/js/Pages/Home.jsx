import Layout from '@/components/Layout'
import Hero from '@/components/sections/Hero'
import TrustBar from '@/components/sections/TrustBar'
import Services from '@/components/sections/Services'
import TechStack from '@/components/sections/TechStack'
import Portfolio from '@/components/sections/Portfolio'
import Testimonials from '@/components/sections/Testimonials'
import Pricing from '@/components/sections/Pricing'
import MaintenanceSection from '@/components/sections/MaintenanceSection'
import FAQ from '@/components/sections/FAQ'
import CTA from '@/components/sections/CTA'
import ContactSection from '@/components/sections/ContactSection'

export default function Home({ services, projects, testimonials, techStacks, categories, pricingPlans }) {
  return (
    <Layout>
      <Hero />
      <TrustBar />
      <Services services={services} />
      <TechStack techStacks={techStacks} />
      <Portfolio projects={projects} categories={categories} />
      <Testimonials testimonials={testimonials} />
      <Pricing pricingPlans={pricingPlans} />
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" aria-hidden="true">
        <div className="h-px bg-gradient-to-r from-transparent via-indigo-500/30 to-transparent" />
      </div>
      <MaintenanceSection />
      <FAQ />
      <CTA />
      <ContactSection />
    </Layout>
  )
}
