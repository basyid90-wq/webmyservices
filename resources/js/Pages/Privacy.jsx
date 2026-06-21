import Layout from '@/components/Layout'

const company = {
  name: 'WebMy Services',
  ssm: '202403295472 (RA0118450-H)',
  address: 'No 2-2A Taman Desa Pangkor, 32300 Pulau Pangkor, Perak.',
  email: 'basyid90@gmail.com',
  phone: '019-4920559',
}

export default function Privacy() {
  return (
    <Layout>
      <section className="pt-32 pb-24">
        <div className="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
          <h1 className="text-3xl font-bold text-white mb-3">Privacy Policy</h1>
          <p className="text-sm text-gray-500 mb-8">Last updated: June 2026</p>

          <div className="bg-white/5 border border-white/10 rounded-xl p-6 mb-6">
            <p className="text-gray-400 text-sm leading-relaxed">
              This Privacy Policy explains how{' '}
              <span className="text-white font-medium">{company.name}</span> (SSM: {company.ssm}), located at {company.address}
              (&quot;we,&quot; &quot;us,&quot; or &quot;our&quot;) collects, uses, discloses, and safeguards your personal information when you visit our website
              or use our services. We are committed to protecting your privacy in compliance with applicable data protection principles and the Malaysian Personal Data Protection Act 2010 (PDPA).
            </p>
          </div>

          <div className="space-y-8 text-gray-400 leading-relaxed">
            <section>
              <h2 className="text-lg font-semibold text-white mb-3">1. Information We Collect</h2>
              <p className="text-sm">We may collect the following types of information when you interact with our website:</p>
              <ul className="list-disc pl-5 space-y-1.5 text-sm mt-2">
                <li>
                  <strong className="text-gray-300">Contact Form Submissions</strong> &mdash; When you fill out our contact form, we collect your name, email address, subject, and message.
                </li>
                <li>
                  <strong className="text-gray-300">Pricing Inquiry Submissions</strong> &mdash; When you submit a pricing inquiry, we collect your full name, company/brand name, WhatsApp number, email address, industry, website goals, reference URLs, content status, additional budget, and any notes you provide.
                </li>
                <li>
                  <strong className="text-gray-300">Automatically Collected Information</strong> &mdash; When you visit our website, certain information is automatically collected, including your IP address, browser type, device type, pages visited, time spent on pages, and referring URL. This data is collected via cookies and similar tracking technologies (see Section 3: Cookies).
                </li>
              </ul>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">2. How We Use Your Information</h2>
              <p className="text-sm">The information we collect is used for the following purposes:</p>
              <ul className="list-disc pl-5 space-y-1.5 text-sm mt-2">
                <li>To respond to your inquiries and provide quotations for our services.</li>
                <li>To follow up regarding your pricing inquiry and discuss your project requirements.</li>
                <li>To deliver, maintain, and improve our website development, hosting, and domain services.</li>
                <li>To send service-related communications including project updates, renewal reminders, and invoices.</li>
                <li>To analyse website traffic and usage patterns in order to improve our website and services (only if you have consented to analytics cookies).</li>
                <li>To comply with legal obligations and enforce our Terms of Service.</li>
              </ul>
              <p className="text-sm mt-3">
                <strong className="text-gray-300">We do not sell, rent, or trade your personal information to any third parties</strong> for their marketing purposes.
              </p>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">3. Cookies & Tracking Technologies</h2>
              <p className="text-sm">
                Our website uses cookies to enhance your browsing experience. We categorise cookies as follows:
              </p>

              <div className="space-y-4 mt-3">
                <div className="bg-white/5 border border-white/10 rounded-lg p-4">
                  <h3 className="text-sm font-semibold text-white mb-2">Essential Cookies (Always Active)</h3>
                  <p className="text-xs">
                    These cookies are strictly necessary for the operation of our website. They enable core functionality such as security (CSRF protection), session management, and cart persistence. Our essential cookies include:
                  </p>
                  <ul className="list-disc pl-5 space-y-1 text-xs mt-1.5">
                    <li><strong className="text-gray-300">XSRF-TOKEN</strong> &mdash; Cross-Site Request Forgery protection for secure form submissions.</li>
                    <li><strong className="text-gray-300">laravel_session</strong> &mdash; Server session identifier for maintaining your browsing state.</li>
                    <li><strong className="text-gray-300">cookie_consent</strong> &mdash; Stores your cookie preference choices (localStorage).</li>
                    <li><strong className="text-gray-300">shop_cart</strong> &mdash; Stores your shopping cart items for the demo e-commerce section (localStorage).</li>
                  </ul>
                </div>

                <div className="bg-white/5 border border-white/10 rounded-lg p-4">
                  <h3 className="text-sm font-semibold text-white mb-2">Analytics Cookies (Optional)</h3>
                  <p className="text-xs">
                    These cookies help us understand how visitors interact with our website by collecting and reporting information anonymously. They are <strong>only activated if you explicitly consent</strong> via our cookie consent banner.
                  </p>
                  <ul className="list-disc pl-5 space-y-1 text-xs mt-1.5">
                    <li><strong className="text-gray-300">Google Analytics (GTM)</strong> &mdash; Tracks page views, session duration, traffic sources, and user behaviour. Data is anonymised.</li>
                    <li><strong className="text-gray-300">Meta Pixel (Facebook)</strong> &mdash; Tracks conversions from Facebook/Instagram ads and builds remarketing audiences. Data is anonymised.</li>
                  </ul>
                </div>
              </div>

              <p className="text-sm mt-4">
                You can change your cookie preferences at any time by clicking the <strong className="text-gray-300">&quot;Cookie Settings&quot;</strong> link in the footer of our website. You may also manage cookies through your browser settings.
              </p>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">4. Third-Party Services</h2>
              <p className="text-sm">
                We may use the following third-party services as part of our operations. These services have their own privacy policies governing the use of your data:
              </p>
              <ul className="space-y-3 mt-3">
                <li className="bg-white/5 border border-white/10 rounded-lg p-4">
                  <p className="text-sm"><strong className="text-gray-300">Bayarcash</strong> &mdash; Payment gateway for processing online payments in our e-commerce shop. Transaction data is processed securely by Bayarcash and is subject to their privacy policy.</p>
                </li>
                <li className="bg-white/5 border border-white/10 rounded-lg p-4">
                  <p className="text-sm"><strong className="text-gray-300">Google Analytics</strong> &mdash; Web analytics service provided by Google. Only activated if you accept analytics cookies. Google may use the collected data to contextualise and personalise ads within its own network. View{' '}
                    <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer" className="text-indigo-400 hover:text-indigo-300">Google's Privacy Policy</a>.</p>
                </li>
                <li className="bg-white/5 border border-white/10 rounded-lg p-4">
                  <p className="text-sm"><strong className="text-gray-300">Meta Pixel</strong> &mdash; Analytics and advertising tool provided by Meta Platforms, Inc. Only activated if you accept analytics cookies. View{' '}
                    <a href="https://www.facebook.com/privacy/policy" target="_blank" rel="noopener noreferrer" className="text-indigo-400 hover:text-indigo-300">Meta's Privacy Policy</a>.</p>
                </li>
              </ul>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">5. Data Storage & Retention</h2>
              <ul className="list-disc pl-5 space-y-1.5 text-sm">
                <li>Contact form submissions and pricing inquiry data are stored securely in our database and retained for as long as necessary to fulfil the purposes for which they were collected, or as required by applicable law.</li>
                <li>Analytics data collected via cookies is retained in accordance with the respective third-party service policies (Google Analytics: up to 26 months by default).</li>
                <li>Server logs and automated usage data are retained for a maximum of 30 days for security monitoring purposes.</li>
              </ul>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">6. Data Security</h2>
              <p className="text-sm">
                We implement appropriate technical and organisational security measures to protect your personal data against unauthorised access, alteration, disclosure, or destruction, including:
              </p>
              <ul className="list-disc pl-5 space-y-1.5 text-sm mt-2">
                <li>Encryption of data in transit (HTTPS/SSL).</li>
                <li>CSRF protection on all forms.</li>
                <li>Secure database access controls.</li>
                <li>Regular security updates to our hosting environment and software stack.</li>
              </ul>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">7. Your Rights</h2>
              <p className="text-sm">
                Under applicable data protection laws, you have the following rights regarding your personal data:
              </p>
              <ul className="list-disc pl-5 space-y-1.5 text-sm mt-2">
                <li><strong className="text-gray-300">Right of Access</strong> &mdash; You may request a copy of the personal data we hold about you.</li>
                <li><strong className="text-gray-300">Right of Rectification</strong> &mdash; You may request that we correct any inaccurate or incomplete personal data.</li>
                <li><strong className="text-gray-300">Right of Erasure</strong> &mdash; You may request that we delete your personal data, subject to legal obligations that require us to retain certain information.</li>
                <li><strong className="text-gray-300">Right to Withdraw Consent</strong> &mdash; Where we rely on your consent to process data (such as analytics cookies), you may withdraw that consent at any time via the Cookie Settings link in our footer.</li>
                <li><strong className="text-gray-300">Right to Object</strong> &mdash; You may object to the processing of your personal data for direct marketing purposes.</li>
              </ul>
              <p className="text-sm mt-3">
                To exercise any of these rights, please contact us at <a href={`mailto:${company.email}`} className="text-indigo-400 hover:text-indigo-300">{company.email}</a>. We will respond to your request within 30 days.
              </p>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">8. Children's Privacy</h2>
              <p className="text-sm">
                Our services are not directed at individuals under the age of 18. We do not knowingly collect personal information from children. If you believe that a child has provided us with personal data, please contact us immediately.
              </p>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">9. Changes to This Policy</h2>
              <p className="text-sm">
                We may update this Privacy Policy from time to time. Any changes will be posted on this page with an updated revision date. We encourage you to review this Privacy Policy periodically to stay informed about how we protect your information.
              </p>
            </section>

            <section>
              <h2 className="text-lg font-semibold text-white mb-3">10. Contact Us</h2>
              <p className="text-sm">
                If you have any questions, concerns, or requests regarding this Privacy Policy or the handling of your personal data, please contact us:
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
