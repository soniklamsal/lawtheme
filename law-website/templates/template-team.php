<?php
/**
 * Template Name: Team Page
 *
 * @package LawFirm_Pro
 */

get_header();

// Get dynamic team data from customizer
$team_title = get_theme_mod( 'lawfirm_team_title', 'Meet Our <span class="text-[#26cf71]">Legal Team</span>' );
$team_subtitle = get_theme_mod( 'lawfirm_team_subtitle', 'Experienced attorneys dedicated to protecting your rights' );

$team_members = get_theme_mod( 'lawfirm_team_members', '' );
if ( ! empty( $team_members ) && is_string( $team_members ) ) {
    $team_members = json_decode( $team_members, true );
}

// Fallback to default data if no dynamic data exists
if ( ! is_array( $team_members ) || empty( $team_members ) ) {
    $team_members = array(
        array(
            'name' => 'Advocate: Gyan R Shakya',
            'specialty' => '',
            'description' => 'Experienced Stakeholders/Shareholders with a demonstrated History of working and Management in the Legal services industry and Banking. Expertise / Skilled in Negotiation, Meditation, Liquidation and Arbitrations. Analytical skills of Consumers Relations Management(CRM) and Administration Strong Professional with Corporate and Banking Law practice.',
            'image' => 'https://images.unsplash.com/photo-1556157382-97eda2d62296?auto=format&fit=crop&w=400',
            'twitter' => '#',
            'facebook' => '#',
            'instagram' => '#',
            'linkedin' => '#',
        ),
        array(
            'name' => 'सरिता गुरुङ',
            'specialty' => '',
            'description' => 'Experienced Legal Professional with demonstrated expertise in Family Law, Civil Litigation, and Property Disputes. Skilled in Legal Research, Client Counseling, Case Management, and Court Representation. Strong analytical skills in Alternative Dispute Resolution (ADR) and Mediation. Dedicated advocate with comprehensive knowledge of Family Law practice and Women Rights Protection.',
            'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400',
            'twitter' => '#',
            'facebook' => '#',
            'instagram' => '#',
            'linkedin' => '#',
        ),
        array(
            'name' => 'अमित थापा',
            'specialty' => '',
            'description' => 'Seasoned Legal Practitioner with extensive experience in Criminal Law, Constitutional Law, and Human Rights. Expertise in Criminal Defense, Bail Applications, Appeals, and Supreme Court Practice. Strong Professional background in Legal Documentation, Case Strategy Development, and Client Advocacy. Specialized in Criminal Justice System and Constitutional Matters.',
            'image' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=400',
            'twitter' => '#',
            'facebook' => '#',
            'instagram' => '#',
            'linkedin' => '#',
        ),
        array(
            'name' => 'प्रिया श्रेष्ठ',
            'specialty' => '',
            'description' => 'Distinguished Legal Expert with comprehensive experience in Corporate Law, Intellectual Property Rights, and Commercial Litigation. Proficient in Contract Drafting, Company Registration, Trademark Registration, and Business Law Compliance. Advanced skills in Corporate Governance, Merger & Acquisitions, and International Business Law. Strong Professional with Corporate Legal Advisory practice.',
            'image' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400',
            'twitter' => '#',
            'facebook' => '#',
            'instagram' => '#',
            'linkedin' => '#',
        ),
    );
}
?>

<main id="primary" class="site-main">
    <!-- Hero Section -->
    <div class="pt-32 px-6 mb-16">
        <div class="max-w-6xl mx-auto text-center">
            <h1 class="text-5xl font-extrabold mb-2 tracking-tight text-[#1A2B3C]">
                <?php echo wp_kses_post( $team_title ); ?>
            </h1>
            <p class="text-lg font-medium opacity-90 text-gray-700">
                <?php echo esc_html( $team_subtitle ); ?>
            </p>
        </div>
    </div>

    <!-- Attorneys Section -->
    <section class="bg-white py-0 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ( $team_members as $attorney ) : ?>
                    <div class="group cursor-pointer flex flex-col h-full">
                        <!-- Attorney Image -->
                        <div class="relative overflow-hidden rounded-2xl mb-4 aspect-[4/5] shadow-lg">
                            <img 
                                src="<?php echo esc_url( $attorney['image'] ); ?>" 
                                alt="<?php echo esc_attr( $attorney['name'] ); ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            />
                        </div>
                        
                        <!-- Attorney Info -->
                        <div class="text-center flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">
                                <?php echo esc_html( $attorney['name'] ); ?>
                            </h3>
                            <p class="text-[#26cf71] text-sm font-semibold mb-3">
                                <?php echo esc_html( $attorney['specialty'] ); ?>
                            </p>
                            
                            <p class="text-gray-600 text-sm leading-relaxed mb-4 flex-grow text-left">
                                <?php echo esc_html( $attorney['description'] ); ?>
                            </p>
                            
                            <!-- Social Media Icons -->
                            <div class="flex gap-3 justify-center">
                                <a href="<?php echo esc_url( $attorney['twitter'] ); ?>" 
                                   class="w-9 h-9 border border-gray-300 rounded-full flex items-center justify-center text-gray-600 hover:bg-[#26cf71] hover:text-white hover:border-[#26cf71] transition-all duration-300"
                                   aria-label="Twitter">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24,4.6c-0.9,0.4-1.8,0.7-2.8,0.8c1-0.6,1.8-1.6,2.2-2.7c-1,0.6-2,1-3.1,1.2c-0.9-1-2.2-1.6-3.6-1.6c-2.7,0-4.9,2.2-4.9,4.9c0,0.4,0,0.8,0.1,1.1C7.7,8.1,4.1,6.1,1.7,3.1C1.2,3.9,1,4.7,1,5.6c0,1.7,0.9,3.2,2.2,4.1C2.4,9.7,1.6,9.5,1,9.1c0,0,0,0,0,0.1c0,2.4,1.7,4.4,3.9,4.8c-0.4,0.1-0.8,0.2-1.3,0.2c-0.3,0-0.6,0-0.9-0.1c0.6,2,2.4,3.4,4.6,3.4c-1.7,1.3-3.8,2.1-6.1,2.1c-0.4,0-0.8,0-1.2-0.1c2.2,1.4,4.8,2.2,7.5,2.2c9.1,0,14-7.5,14-14c0-0.2,0-0.4,0-0.6C22.5,6.4,23.3,5.5,24,4.6z"/>
                                    </svg>
                                </a>
                                <a href="<?php echo esc_url( $attorney['facebook'] ); ?>" 
                                   class="w-9 h-9 border border-gray-300 rounded-full flex items-center justify-center text-gray-600 hover:bg-[#26cf71] hover:text-white hover:border-[#26cf71] transition-all duration-300"
                                   aria-label="Facebook">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24,12c0,6.6-5.4,12-12,12S0,18.6,0,12S5.4,0,12,0S24,5.4,24,12z M12.7,12h2.4l0.3-3h-2.7V7.5c0-0.8,0.1-1.2,1.2-1.2h1.5V3.6h-2.4c-2.9,0-3.8,1.5-3.8,3.9V9H7.5v3h1.7v8.6h3.5V12z"/>
                                    </svg>
                                </a>
                                <a href="<?php echo esc_url( $attorney['instagram'] ); ?>" 
                                   class="w-9 h-9 border border-gray-300 rounded-full flex items-center justify-center text-gray-600 hover:bg-[#26cf71] hover:text-white hover:border-[#26cf71] transition-all duration-300"
                                   aria-label="Instagram">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,2.2c3.2,0,3.6,0,4.9,0.1c3.3,0.1,4.8,1.7,4.9,4.9c0.1,1.3,0.1,1.6,0.1,4.8s0,3.6-0.1,4.8c-0.1,3.2-1.7,4.8-4.9,4.9c-1.3,0.1-1.6,0.1-4.9,0.1s-3.6,0-4.9-0.1c-3.3-0.1-4.8-1.7-4.9-4.9c-0.1-1.3-0.1-1.6-0.1-4.8s0-3.6,0.1-4.8c0.1-3.2,1.7-4.8,4.9-4.9C8.4,2.2,8.8,2.2,12,2.2z M12,0C8.7,0,8.3,0,7.1,0.1C2.7,0.2,0.2,2.7,0.1,7.1C0,8.3,0,8.7,0,12s0,3.7,0.1,4.9c0.1,4.4,2.6,6.9,7,7C8.3,24,8.7,24,12,24s3.7,0,4.9-0.1c4.4-0.1,6.9-2.6,7-7C24,15.7,24,15.3,24,12s0-3.7-0.1-4.9c-0.1-4.3-2.6-6.8-7-7C15.7,0,15.3,0,12,0z M12,5.8c-3.4,0-6.2,2.8-6.2,6.2s2.8,6.2,6.2,6.2s6.2-2.8,6.2-6.2S15.4,5.8,12,5.8z M12,16c-2.2,0-4-1.8-4-4s1.8-4,4-4s4,1.8,4,4S14.2,16,12,16z M18.4,4.2c-0.8,0-1.4,0.6-1.4,1.4s0.6,1.4,1.4,1.4s1.4-0.6,1.4-1.4S19.2,4.2,18.4,4.2z"/>
                                    </svg>
                                </a>
                                <a href="<?php echo esc_url( $attorney['linkedin'] ); ?>" 
                                   class="w-9 h-9 border border-gray-300 rounded-full flex items-center justify-center text-gray-600 hover:bg-[#26cf71] hover:text-white hover:border-[#26cf71] transition-all duration-300"
                                   aria-label="LinkedIn">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.5,2h-17C2.7,2,2,2.6,2,3.4v17.1C2,21.4,2.7,22,3.5,22h17c0.8,0,1.5-0.6,1.5-1.4V3.4C22,2.6,21.3,2,20.5,2z M8.3,18.9H5.5V9.7h2.8V18.9z M6.9,8.5C6,8.5,5.3,7.8,5.3,6.9s0.7-1.6,1.6-1.6s1.6,0.7,1.6,1.6S7.8,8.5,6.9,8.5z M18.9,18.9h-2.8v-4.5c0-1.1,0-2.5-1.5-2.5s-1.7,1.2-1.7,2.4v4.6h-2.8V9.7h2.7v1.2h0c0.4-0.7,1.3-1.5,2.7-1.5c2.9,0,3.4,1.9,3.4,4.4V18.9z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
