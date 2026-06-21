import Layout from '@/components/Layout'

const company = {
  name: 'WebMy Services',
  ssm: '202403295472 (RA0118450-H)',
  address: 'No 2-2A Taman Desa Pangkor, 32300 Pulau Pangkor, Perak.',
  email: 'basyid90@gmail.com',
  phone: '019-4920559',
}

export default function Terms() {
  return (
    <Layout>
      <section className="pt-32 pb-24">
        <div className="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
          <h1 className="text-3xl font-bold text-white mb-3">Terms of Service</h1>
          <p className="text-sm text-gray-500 mb-8">Last updated: June 2026</p>

          <div className="bg-white/5 border border-white/10 rounded-xl p-6 mb-6">
            <p className="text-gray-400 text-sm leading-relaxed">
              These Terms of Service (&quot;Terms&quot;) govern your use of the website development, hosting, domain registration, and related digital services provided by{' '}
              <span className="text-white font-medium">{company.name}</span> (SSM: {company.ssm}), located at {company.address}
              (&quot;we,&quot; &quot;us,&quot; or &quot;the Agency&quot;). By engaging our services, you (&quot;Client,&quot; &quot;you&quot;) agree to be bound by these Terms.
            </p>
          </div>

          <div className="space-y-8 text-gray-400 leading-relaxed">
            <section>
              <h2 className="text-lg font-semibold text-white mb-3">1. Definitions</h2>
              <ul className="space-y-2 text-sm">
                <li><strong className="text-gray-300">Agency</strong> &mdash; {company.name}, the service provider.</li>
                <li><strong className="text-gray-300">Client</strong> &mdash; The individual or entity engaging the Agency for services.</li>
                <li><strong className="text-gray-300">Project</strong> &mdash; Any website, web application, or digital deliverable agreed upon between the Agency and Client.</li>
                <li><strong className="text-gray-300">Deliverables</strong> &mdash; The final output including source code, design assets, documentation, and deployed website.</li>
                <li><strong className="text-gray-300">Go-Live</strong> &mdash; The point at which the completed website is made publicly accessible on the Client's domain or hosting.</li>
              </ul>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">2. Scope of Services</h2>
              <p className="text-sm">
                The Agency provides the following services:
              </p>
              <ul className="list-disc pl-5 space-y-1.5 text-sm mt-2">
                <li>Website design and development (landing pages, company profiles, e-commerce, custom systems)</li>
                <li>Domain name registration and management</li>
                <li>Web hosting and VPS setup</li>
                <li>Search engine optimisation (SEO)</li>
                <li>Website maintenance and support</li>
                <li>Content management system (CMS) installation</li>
              </ul>
              <p className="text-sm mt-3">
                The exact scope, features, and deliverables for each project shall be documented in a separate project proposal or quotation provided to the Client before work commences.
              </p>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">3. Project Timeline</h2>
              <p className="text-sm">
                The Agency will provide an estimated timeline before the project begins:
              </p>
              <ul className="list-disc pl-5 space-y-1.5 text-sm mt-2">
                <li><strong className="text-gray-300">Small projects</strong> (landing pages, simple company profiles): 3&ndash;5 working days.</li>
                <li><strong className="text-gray-300">Medium projects</strong> (multi-page websites, basic e-commerce): 7&ndash;14 working days.</li>
                <li><strong className="text-gray-300">Large projects</strong> (custom systems, complex web apps): timeline provided in proposal.</li>
              </ul>
              <p className="text-sm mt-3">
                Timelines are estimates and depend on the Client providing all required content, feedback, and approvals in a timely manner. Delays caused by the Client will extend the project timeline accordingly.
              </p>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">4. Client Responsibilities</h2>
              <p className="text-sm">To ensure smooth and timely delivery, the Client agrees to:</p>
              <ul className="list-disc pl-5 space-y-1.5 text-sm mt-2">
                <li>Provide all necessary content (text, images, logos, brand guidelines) before or during the development phase.</li>
                <li>Provide clear feedback and approvals within 2&ndash;3 working days of receiving design previews.</li>
                <li>Ensure that any third-party credentials (hosting, domain, email) are shared securely with the Agency when required.</li>
                <li>Own or have the legal right to use all content, images, and trademarks provided to the Agency.</li>
              </ul>
              <p className="text-sm mt-3">
                The Agency is not liable for delays caused by the Client's failure to meet these responsibilities.
              </p>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">5. Payment Terms</h2>
              <ul className="space-y-2 text-sm">
                <li className="flex items-start gap-2">
                  <span className="text-indigo-400 mt-1">&#8226;</span>
                  <span><strong className="text-gray-300">Website Development</strong> &mdash; One-time payment based on the agreed project fee. 50% deposit is required to commence work, with the remaining 50% due before Go-Live. Full payment must be settled before the website files and admin access are handed over to the Client.</span>
                </li>
                <li className="flex items-start gap-2">
                  <span className="text-indigo-400 mt-1">&#8226;</span>
                  <span><strong className="text-gray-300">Domain Registration</strong> &mdash; Yearly renewal fee. The Client will be notified at least 14 days before expiry. Non-payment of renewal fees may result in domain suspension or loss.</span>
                </li>
                <li className="flex items-start gap-2">
                  <span className="text-indigo-400 mt-1">&#8226;</span>
                  <span><strong className="text-gray-300">Hosting / VPS</strong> &mdash; Yearly renewal fee. The Client will be notified at least 14 days before expiry. The Agency reserves the right to suspend hosting services if payment is not received by the due date.</span>
                </li>
                <li className="flex items-start gap-2">
                  <span className="text-indigo-400 mt-1">&#8226;</span>
                  <span><strong className="text-gray-300">Website Maintenance</strong> &mdash; Monthly or annual fee as agreed in the project proposal. Covers updates, backups, security patches, and minor content changes.</span>
                </li>
              </ul>
              <p className="text-sm mt-3">
                All prices are quoted in Malaysian Ringgit (RM). Payment may be made via bank transfer, online payment gateway, or other methods agreed upon in writing.
              </p>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">6. Refund Policy</h2>
              <ul className="list-disc pl-5 space-y-1.5 text-sm">
                <li>If the Client cancels the project before any design or development work has commenced, a 50% refund of the deposit will be issued.</li>
                <li>Once design or development work has begun, no refunds will be provided for that phase of work.</li>
                <li>Domain, hosting, and third-party service fees are non-refundable once purchased.</li>
                <li>Any refund request must be submitted in writing to {company.email}.</li>
              </ul>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">7. Intellectual Property</h2>
              <ul className="list-disc pl-5 space-y-1.5 text-sm">
                <li>Upon full payment, the Client owns the final website design and content specific to their project.</li>
                <li>The Agency retains ownership of any reusable code, frameworks, libraries, or tools developed during the project that are not project-specific.</li>
                <li>The Agency reserves the right to display the completed project in its portfolio, website, and marketing materials unless otherwise agreed in writing.</li>
              </ul>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">8. Limitation of Liability</h2>
              <p className="text-sm">
                The Agency shall not be liable for any indirect, incidental, or consequential damages arising from the use or inability to use the delivered website or services. The Agency's total liability for any claim shall not exceed the total fees paid by the Client for the specific project in question.
              </p>
              <p className="text-sm mt-2">
                The Agency is not responsible for third-party service disruptions including but not limited to domain registrar outages, hosting provider downtime, or payment gateway failures.
              </p>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">9. Termination</h2>
              <p className="text-sm">
                Either party may terminate the agreement with 7 days written notice. Upon termination, the Client shall pay for all work completed up to the date of termination. The Agency shall deliver all completed work for which payment has been received.
              </p>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">10. Governing Law</h2>
              <p className="text-sm">
                These Terms shall be governed by and construed in accordance with the laws of Malaysia. Any disputes arising from these Terms shall be subject to the exclusive jurisdiction of the courts of Malaysia.
              </p>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">11. Contact</h2>
              <p className="text-sm">
                For any questions regarding these Terms, please contact us:
              </p>
              <div className="bg-white/5 border border-white/10 rounded-lg p-4 mt-3 text-sm space-y-1">
                <p><strong className="text-gray-300">{company.name}</strong></p>
                <p>SSM: {company.ssm}</p>
                <p>{company.address}</p>
                <p>Email: <a href={`mailto:${company.email}`} className="text-indigo-400 hover:text-indigo-300">{company.email}</a></p>
                <p>Phone: <a href={`tel:${company.phone}`} className="text-indigo-400 hover:text-indigo-300">{company.phone}</a></p>
              </div>
            </section>
          </div>
        </div>
      </section>
    </Layout>
  )
}
