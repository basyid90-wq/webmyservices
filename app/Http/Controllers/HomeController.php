<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\TechStack;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->get();
        $projects = Project::where('is_published', true)
            ->with('client')
            ->orderBy('sort_order')
            ->latest()
            ->take(6)
            ->get();
        $testimonials = Testimonial::orderBy('sort_order')->get();
        $techStacks = TechStack::orderBy('sort_order')->get();
        $categories = ProjectCategory::orderBy('sort_order')->get();
        $pricingPlans = PricingPlan::where('is_active', true)->orderBy('sort_order')->get();

        return Inertia::render('Home', [
            'services' => $services,
            'projects' => $projects,
            'testimonials' => $testimonials,
            'techStacks' => $techStacks,
            'categories' => $categories,
            'pricingPlans' => $pricingPlans,
        ]);
    }

    public function contact()
    {
        return Inertia::render('Contact');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\Contact::create($validated);

        return redirect()->route('contact')->with('success', 'Thank you! Your message has been sent.');
    }

    public function pricingInquiry(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('pricingInquiry reached', $request->all());

        $validated = $request->validate([
            'plan_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'whatsapp' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'industry' => 'nullable|string|max:255',
            'website_goal' => 'nullable|string|max:255',
            'reference_urls' => 'nullable|string',
            'content_status' => 'nullable|string|max:255',
            'additional_budget' => 'nullable|numeric',
            'message' => 'nullable|string',
        ]);

        $validated['subject'] = $validated['plan_name'] . ' Plan Inquiry';
        $validated['is_read'] = false;

        \App\Models\Contact::create($validated);

        \Illuminate\Support\Facades\Log::info('pricingInquiry saved successfully');

        return response()->json(['success' => true]);
    }
}
