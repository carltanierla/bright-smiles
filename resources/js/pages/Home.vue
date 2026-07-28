<template>
    <div
        class="overflow-x-hidden bg-white font-sans text-slate-900 antialiased selection:bg-blue-900 selection:text-white"
    >
        <nav
            class="fixed z-50 w-full border-b border-slate-100 bg-white/90 backdrop-blur-lg transition-all duration-500"
        >
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div class="flex h-28 items-center justify-between">
                    <a
                        href="#"
                        class="flex items-center gap-2 tracking-widest transition-opacity hover:opacity-80"
                    >
                        <img
                            src="/images/BrightSmiles.png"
                            onerror="
                                this.onerror = null;
                                this.src =
                                    'https://static.wixstatic.com/media/dd7742_f822f1d52c2e4135bdab54e19596ee94~mv2.jpg/v1/crop/x_0,y_126,w_1192,h_288/fill/w_466,h_112,al_c,q_80,usm_0.66_1.00_0.01,enc_avif,quality_auto/Bright%20Smiles%20Orthodontic%20Service_JPG.jpg';
                            "
                            alt="Bright Smiles"
                            class="h-9 w-auto object-contain"
                        />
                    </a>
                    <div class="hidden items-center space-x-12 md:flex">
                        <a
                            href="#"
                            class="text-xs font-semibold tracking-widest text-slate-400 uppercase transition-colors duration-300 hover:text-blue-900"
                            >Home</a
                        >
                        <a
                            href="#about"
                            class="text-xs font-semibold tracking-widest text-slate-400 uppercase transition-colors duration-300 hover:text-blue-900"
                            >Dr Ben</a
                        >
                        <a
                            href="#transformations"
                            class="text-xs font-semibold tracking-widest text-slate-400 uppercase transition-colors duration-300 hover:text-blue-900"
                            >Results</a
                        >
                        <a
                            href="#technology"
                            class="text-xs font-semibold tracking-widest text-slate-400 uppercase transition-colors duration-300 hover:text-blue-900"
                            >Technology</a
                        >
                        <a
                            href="#locations"
                            class="text-xs font-semibold tracking-widest text-slate-400 uppercase transition-colors duration-300 hover:text-blue-900"
                            >Locations</a
                        >
                        <Link
                            href="/onlineform"
                            class="bg-blue-900 px-8 py-4 text-xs font-bold tracking-widest text-white uppercase shadow-sm transition-all duration-300 hover:bg-slate-900 hover:shadow-lg"
                        >
                            Book Online
                        </Link>
                    </div>
                    <div class="flex items-center md:hidden">
                        <button
                            @click="toggleMenu"
                            class="p-2 text-slate-900 transition-colors hover:text-blue-900 focus:outline-none"
                        >
                            <i
                                :class="
                                    isMobileMenuOpen
                                        ? 'fa-solid fa-xmark text-2xl'
                                        : 'fa-solid fa-bars text-2xl'
                                "
                            ></i>
                        </button>
                    </div>
                </div>
            </div>

            <div
                :class="[
                    'absolute w-full origin-top flex-col border-t border-slate-100 bg-white px-6 py-6 shadow-2xl transition-all duration-300 md:hidden',
                    isMobileMenuOpen
                        ? 'scale-y-100 opacity-100'
                        : 'pointer-events-none scale-y-0 opacity-0',
                ]"
            >
                <a
                    @click="toggleMenu"
                    href="#about"
                    class="block border-b border-slate-50 py-4 font-semibold tracking-wide text-slate-600"
                    >Meet Dr Ben</a
                >
                <a
                    @click="toggleMenu"
                    href="#transformations"
                    class="block border-b border-slate-50 py-4 font-semibold tracking-wide text-slate-600"
                    >Transformations</a
                >
                <a
                    @click="toggleMenu"
                    href="#technology"
                    class="block border-b border-slate-50 py-4 font-semibold tracking-wide text-slate-600"
                    >Technology</a
                >
                <a
                    @click="toggleMenu"
                    href="#locations"
                    class="block border-b border-slate-50 py-4 font-semibold tracking-wide text-slate-600"
                    >Locations</a
                >
                <a
                    @click="toggleMenu"
                    href="#faq"
                    class="block border-b border-slate-50 py-4 font-semibold tracking-wide text-slate-600"
                    >FAQ</a
                >
                <Link
                    href="/onlineform"
                    @click="toggleMenu"
                    class="mt-6 block bg-blue-900 py-4 text-center text-xs font-bold tracking-widest text-white uppercase"
                    >Start Your Journey
                </Link>
            </div>
        </nav>

        <section
            class="relative overflow-hidden bg-slate-50 pt-48 pb-28 lg:pt-64 lg:pb-44"
        >
            <div class="relative z-10 mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div class="grid items-center gap-16 lg:grid-cols-12 lg:gap-8">
                    <div
                        class="lg:col-span-6"
                        data-aos="fade-up"
                        data-aos-duration="1200"
                    >
                        <h1
                            class="font-display mb-10 text-5xl leading-none font-light tracking-tight text-slate-900 sm:text-6xl lg:text-7xl"
                        >
                            Your Smile.<br />
                            <span class="font-bold text-blue-900"
                                >Your Confidence.</span
                            ><br />
                            Your Future.
                        </h1>
                        <p
                            class="mb-12 max-w-lg text-lg leading-relaxed font-light text-slate-500 sm:text-xl"
                        >
                            Specialist Orthodontic Care for Children, Teens &
                            Adults. Experience world-class digital smile design
                            in an exclusive, high-end environment.
                        </p>
                        <div
                            class="flex max-w-md flex-col gap-4 sm:max-w-none sm:flex-row"
                        >
                            <Link href="/onlineform">
                                <a
                                    class="flex items-center justify-center gap-3 bg-blue-900 px-10 py-5 text-center text-xs font-bold tracking-widest text-white uppercase shadow-md transition-all duration-300 hover:bg-slate-900 hover:shadow-xl"
                                >
                                    Schedule Your Consultation
                                    <i
                                        class="fa-solid fa-arrow-right text-xs"
                                    ></i>
                                </a>
                            </Link>
                            <a
                                href="#transformations"
                                class="flex items-center justify-center border border-slate-300 bg-transparent px-10 py-5 text-center text-xs font-bold tracking-widest text-slate-900 uppercase transition-all duration-300 hover:border-slate-400 hover:bg-white"
                            >
                                See What's Possible
                            </a>
                        </div>
                    </div>

                    <div
                        class="relative lg:col-span-6"
                        data-aos="fade-up"
                        data-aos-duration="1200"
                        data-aos-delay="200"
                    >
                        <div
                            class="group relative h-137.5 overflow-hidden bg-slate-200 shadow-2xl lg:h-162.5"
                        >
                            <img
                                src="/images/BrightSmileHero1.png"
                                onerror="
                                    this.onerror = null;
                                    this.src =
                                        'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=800&q=80';
                                "
                                alt="Confident Patient Experiencing Professional Orthodontic Care"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-y border-slate-100 bg-white py-16">
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div
                    class="grid grid-cols-2 gap-12 divide-y divide-slate-100 text-center md:grid-cols-4 md:gap-4 md:divide-x md:divide-y-0"
                >
                    <div
                        v-for="(stat, index) in stats"
                        :key="index"
                        class="pt-6 md:pt-0"
                        data-aos="fade-in"
                        :data-aos-delay="index * 150"
                    >
                        <p
                            class="font-display mb-3 text-4xl font-bold text-blue-900 lg:text-5xl"
                        >
                            {{ stat.number }}
                        </p>
                        <p
                            class="text-xs font-bold tracking-widest text-slate-400 uppercase"
                        >
                            {{ stat.label }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-slate-50 py-32 lg:py-44">
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div
                    class="mx-auto mb-24 max-w-2xl text-center"
                    data-aos="fade-up"
                >
                    <h2
                        class="mb-4 text-xs font-bold tracking-widest text-blue-900 uppercase"
                    >
                        The Bright Smiles Difference
                    </h2>
                    <h3
                        class="font-display text-4xl font-bold text-slate-900 lg:text-5xl"
                    >
                        Why Families Choose Us
                    </h3>
                </div>
                <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="(reason, index) in reasons"
                        :key="index"
                        class="flex flex-col justify-between border border-slate-100 bg-white p-10 transition-all duration-300 hover:border-slate-200 hover:shadow-xl"
                        data-aos="fade-up"
                        :data-aos-delay="index * 100"
                    >
                        <div>
                            <div
                                class="mb-8 flex h-12 w-12 items-center justify-center rounded-none bg-slate-50"
                            >
                                <i
                                    class="fa-solid fa-square-check text-xl text-blue-900"
                                ></i>
                            </div>
                            <h4 class="mb-4 text-lg font-bold text-slate-900">
                                {{ reason.title }}
                            </h4>
                            <p
                                class="text-sm leading-relaxed font-light text-slate-500"
                            >
                                {{ reason.desc }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section with Integrated Auto-sliding Gallery -->
        <section
            id="about"
            class="border-t border-slate-100 bg-white py-32 lg:py-44"
        >
            <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
                <div class="grid items-center gap-20 lg:grid-cols-12">
                    <div
                        class="lg:col-span-6"
                        data-aos="fade-right"
                        data-aos-duration="1200"
                    >
                        <div
                            class="group relative h-150 overflow-hidden bg-slate-100 shadow-2xl"
                        >
                            <transition name="fade" mode="out-in">
                                <img
                                    :key="currentAboutIndex"
                                    :src="aboutImages[currentAboutIndex].src"
                                    @error="
                                        (
                                            $event.target as HTMLImageElement
                                        ).src =
                                            aboutImages[
                                                currentAboutIndex
                                            ].fallback
                                    "
                                    :alt="aboutImages[currentAboutIndex].alt"
                                    class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-103"
                                />
                            </transition>
                            <!-- Optional Slide Visual Indicators -->
                            <div
                                class="absolute bottom-6 left-6 z-10 flex gap-2 bg-slate-950/40 p-2 backdrop-blur-xs"
                            >
                                <span
                                    v-for="(_, index) in aboutImages"
                                    :key="index"
                                    :class="[
                                        'h-1.5 transition-all duration-300',
                                        currentAboutIndex === index
                                            ? 'w-6 bg-white'
                                            : 'w-1.5 bg-white/50',
                                    ]"
                                ></span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="lg:col-span-6"
                        data-aos="fade-left"
                        data-aos-duration="1200"
                    >
                        <h2
                            class="mb-4 text-xs font-bold tracking-widest text-blue-900 uppercase"
                        >
                            Your Professional Smile Designer
                        </h2>
                        <h3
                            class="font-display mb-8 text-4xl leading-tight font-bold text-slate-900 lg:text-5xl"
                        >
                            Dr. Benjamin Tai
                        </h3>

                        <p
                            class="mb-12 max-w-2xl text-xl leading-relaxed font-light text-slate-500"
                        >
                            People don't just invest in clinical alignment; they
                            trust the practitioner behind the artistry. Dr. Tai
                            combines meticulous biomedical detail with decades
                            of specialized clinical training to deliver elite
                            dental architecture.
                        </p>

                        <div class="mb-12 grid gap-6 sm:grid-cols-2">
                            <div
                                class="flex items-start gap-4 border border-slate-100 bg-slate-50 p-4"
                            >
                                <i
                                    class="fa-solid fa-ribbon mt-0.5 text-lg text-blue-900"
                                ></i>
                                <div>
                                    <h5
                                        class="mb-1 text-sm font-bold text-slate-900"
                                    >
                                        Elite Accreditation
                                    </h5>
                                    <p
                                        class="text-xs font-light text-slate-500"
                                    >
                                        Award-winning Specialist Orthodontist &
                                        Doctorate Graduate
                                    </p>
                                </div>
                            </div>
                            <div
                                class="flex items-start gap-4 border border-slate-100 bg-slate-50 p-4"
                            >
                                <i
                                    class="fa-solid fa-graduation-cap mt-0.5 text-lg text-blue-900"
                                ></i>
                                <div>
                                    <h5
                                        class="mb-1 text-sm font-bold text-slate-900"
                                    >
                                        Academic Eminence
                                    </h5>
                                    <p
                                        class="text-xs font-light text-slate-500"
                                    >
                                        Doctor of Clinical Dentistry
                                        (Orthodontics), UWA
                                    </p>
                                </div>
                            </div>
                            <div
                                class="flex items-start gap-4 border border-slate-100 bg-slate-50 p-4"
                            >
                                <i
                                    class="fa-solid fa-wand-magic-sparkles mt-0.5 text-lg text-blue-900"
                                ></i>
                                <div>
                                    <h5
                                        class="mb-1 text-sm font-bold text-slate-900"
                                    >
                                        Digital Mapping Master
                                    </h5>
                                    <p
                                        class="text-xs font-light text-slate-500"
                                    >
                                        Advanced Digital Smile Design Expert &
                                        Innovator
                                    </p>
                                </div>
                            </div>
                            <div
                                class="flex items-start gap-4 border border-slate-100 bg-slate-50 p-4"
                            >
                                <i
                                    class="fa-solid fa-gem mt-0.5 text-lg text-blue-900"
                                ></i>
                                <div>
                                    <h5
                                        class="mb-1 text-sm font-bold text-slate-900"
                                    >
                                        Proven Outcomes
                                    </h5>
                                    <p
                                        class="text-xs font-light text-slate-500"
                                    >
                                        Thousands of complex smiles curated
                                        across Australia
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="max-w-xl border-l-4 border-blue-900 pl-8">
                            <p
                                class="font-display text-xl leading-relaxed text-slate-900 italic"
                            >
                                "Orthodontics is the architecture of
                                self-esteem. We don't just reposition teeth; we
                                design the structural foundation for your
                                lifelong confidence."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section
            id="transformations"
            class="overflow-hidden bg-slate-950 py-32 text-white lg:py-44"
        >
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div
                    class="mb-24 flex flex-col items-stretch justify-between gap-8 md:flex-row md:items-end"
                >
                    <div class="max-w-xl">
                        <h2
                            class="mb-4 text-xs font-bold tracking-widest text-blue-400 uppercase"
                        >
                            Case Studies
                        </h2>
                        <h3
                            class="font-display text-4xl leading-tight font-bold lg:text-5xl"
                        >
                            Changing Smiles.<br />Changing Lives.
                        </h3>
                    </div>
                    <div class="flex gap-3 self-end">
                        <button
                            @click="prevTransformation"
                            class="flex h-14 w-14 items-center justify-center border border-slate-800 transition-all duration-300 hover:border-white hover:bg-white hover:text-slate-950"
                            aria-label="Previous Case Study"
                        >
                            <i class="fa-solid fa-arrow-left text-sm"></i>
                        </button>
                        <button
                            @click="nextTransformation"
                            class="flex h-14 w-14 items-center justify-center border border-slate-800 transition-all duration-300 hover:border-white hover:bg-white hover:text-slate-950"
                            aria-label="Next Case Study"
                        >
                            <i class="fa-solid fa-arrow-right text-sm"></i>
                        </button>
                    </div>
                </div>

                <div
                    class="relative overflow-hidden border border-slate-900 bg-slate-900 shadow-2xl"
                >
                    <transition name="fade" mode="out-in">
                        <div
                            :key="activeTransformation.id"
                            class="grid items-stretch lg:grid-cols-12"
                        >
                            <div
                                class="group relative flex h-80 bg-slate-800 sm:h-[450px] lg:col-span-6 lg:h-[550px]"
                            >
                                <div
                                    class="relative h-full w-1/2 overflow-hidden border-r border-slate-900"
                                >
                                    <img
                                        :src="activeTransformation.beforeImg"
                                        onerror="
                                            this.onerror = null;
                                            this.src =
                                                'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=400&q=80';
                                        "
                                        class="h-full w-full object-cover grayscale transition-transform duration-700 group-hover:scale-103"
                                        alt="Orthodontic clinical case alignment state before care"
                                    />
                                    <span
                                        class="absolute bottom-6 left-6 border border-white/10 bg-slate-950/80 px-3 py-1.5 text-[10px] font-bold tracking-widest text-slate-300 uppercase backdrop-blur-md"
                                        >Before</span
                                    >
                                </div>
                                <div
                                    class="relative h-full w-1/2 overflow-hidden"
                                >
                                    <img
                                        :src="activeTransformation.afterImg"
                                        onerror="
                                            this.onerror = null;
                                            this.src =
                                                'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=400&q=80';
                                        "
                                        class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-103"
                                        alt="Final precision orthodontic alignment result after care"
                                    />
                                    <span
                                        class="absolute right-6 bottom-6 bg-blue-900 px-3 py-1.5 text-[10px] font-bold tracking-widest text-white uppercase"
                                        >After</span
                                    >
                                </div>
                            </div>

                            <div
                                class="flex flex-col justify-center bg-gradient-to-br from-slate-900 to-slate-950 p-10 sm:p-16 lg:col-span-6"
                            >
                                <div class="mb-4 flex items-center gap-3">
                                    <span
                                        class="text-xs font-bold tracking-widest text-blue-400 uppercase"
                                        >{{
                                            activeTransformation.treatment
                                        }}</span
                                    >
                                    <span
                                        class="h-1 w-1 rounded-full bg-slate-700"
                                    ></span>
                                    <span
                                        class="text-xs tracking-widest text-slate-400 uppercase"
                                        >{{
                                            activeTransformation.duration
                                        }}</span
                                    >
                                </div>
                                <h4
                                    class="font-display mb-8 text-3xl font-bold text-white sm:text-4xl"
                                >
                                    {{ activeTransformation.name }},
                                    <span
                                        class="text-2xl font-light text-slate-400 sm:text-3xl"
                                        >Age
                                        {{ activeTransformation.age }}</span
                                    >
                                </h4>
                                <blockquote
                                    class="mb-10 border-l-2 border-blue-500 pl-6 text-lg leading-relaxed font-light text-slate-300 italic sm:text-xl"
                                >
                                    "{{ activeTransformation.quote }}"
                                </blockquote>
                                <div>
                                    <a
                                        href="#booking"
                                        class="group inline-flex items-center gap-3 text-xs font-bold tracking-widest text-white uppercase transition-colors duration-300 hover:text-blue-400"
                                    >
                                        Book Similar Consultation
                                        <i
                                            class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"
                                        ></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </section>

        <section id="technology" class="bg-slate-50 py-32 lg:py-44">
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div
                    class="mx-auto mb-24 max-w-2xl text-center"
                    data-aos="fade-up"
                >
                    <h2
                        class="mb-4 text-xs font-bold tracking-widest text-blue-900 uppercase"
                    >
                        Precision & Comfort
                    </h2>
                    <h3
                        class="font-display text-4xl font-bold text-slate-900 lg:text-5xl"
                    >
                        Advanced 3D Smile Technology
                    </h3>
                </div>

                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="(tech, index) in technologies"
                        :key="index"
                        class="group flex flex-col justify-between border border-slate-200/60 bg-white p-10 transition-all duration-500 hover:border-blue-900 hover:shadow-xl"
                        data-aos="fade-up"
                        :data-aos-delay="index * 100"
                    >
                        <div>
                            <div
                                class="mb-8 flex h-14 w-14 items-center justify-center bg-slate-50 text-xl text-blue-900 transition-colors duration-500 group-hover:bg-blue-900/5"
                            >
                                <i :class="tech.icon"></i>
                            </div>
                            <h4 class="mb-4 text-lg font-bold text-slate-900">
                                {{ tech.title }}
                            </h4>
                            <p
                                class="text-sm leading-relaxed font-light text-slate-500"
                            >
                                {{ tech.desc }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-y border-slate-100 bg-white py-32 lg:py-44">
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div
                    class="mx-auto mb-24 max-w-2xl text-center"
                    data-aos="fade-up"
                >
                    <h2
                        class="mb-4 text-xs font-bold tracking-widest text-blue-900 uppercase"
                    >
                        The Process
                    </h2>
                    <h3 class="font-display text-4xl font-bold text-slate-900">
                        Your Journey to a Perfect Smile
                    </h3>
                </div>

                <div class="relative mx-auto max-w-5xl">
                    <div
                        class="absolute top-12 left-0 z-0 hidden h-px w-full bg-slate-200 md:block"
                    ></div>

                    <div
                        class="relative z-10 grid gap-12 md:grid-cols-4 md:gap-8"
                    >
                        <div
                            v-for="(step, index) in journeySteps"
                            :key="index"
                            class="group text-center"
                            data-aos="fade-up"
                            :data-aos-delay="index * 150"
                        >
                            <div
                                class="relative mx-auto mb-6 flex h-24 w-24 items-center justify-center border border-slate-200 bg-white bg-linear-to-b from-white to-slate-50/50 text-sm font-bold text-blue-900 shadow-sm transition-colors duration-500 group-hover:border-blue-900"
                            >
                                0{{ index + 1 }}
                            </div>
                            <h4 class="mb-3 text-base font-bold text-slate-900">
                                {{ step.title }}
                            </h4>
                            <p
                                class="mx-auto max-w-xs text-xs leading-relaxed font-light text-slate-400"
                            >
                                {{ step.desc }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section
            id="testimonials"
            class="overflow-hidden border-b border-slate-100 bg-slate-50 py-32 lg:py-44"
        >
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div class="mx-auto mb-30 max-w-2xl text-center">
                    <h2
                        class="mb-4 text-xs font-bold tracking-widest text-blue-900 uppercase"
                    >
                        Verified Experiences
                    </h2>
                    <h3 class="font-display text-4xl font-bold text-slate-900">
                        Patient Endorsements
                    </h3>
                </div>

                <div class="relative mx-auto max-w-4xl px-4">
                    <div
                        class="relative flex h-64 items-center justify-center sm:h-52 md:h-44"
                    >
                        <div
                            v-for="(testimonial, index) in testimonials"
                            :key="index"
                            v-show="currentIndex === index"
                            class="absolute inset-x-0 text-center transition-all duration-700"
                        >
                            <p
                                class="font-display mx-auto mb-6 max-w-3xl text-xl leading-relaxed text-slate-800 italic sm:text-2xl"
                            >
                                "{{ testimonial.quote }}"
                            </p>
                            <div class="flex items-center justify-center gap-3">
                                <span
                                    class="text-sm font-bold text-slate-900"
                                    >{{ testimonial.name }}</span
                                >
                                <span
                                    class="h-1 w-1 rounded-full bg-slate-300"
                                ></span>
                                <span
                                    class="text-xs font-semibold tracking-wider text-blue-900 uppercase"
                                    >{{ testimonial.treatment }}</span
                                >
                            </div>
                        </div>
                    </div>

                    <div class="mt-30 flex justify-center gap-3">
                        <button
                            v-for="(_, index) in testimonials"
                            :key="index"
                            @click="setSlide(index)"
                            :class="[
                                'h-2 w-2 rounded-full transition-all duration-300 focus:outline-none',
                                currentIndex === index
                                    ? 'w-6 bg-blue-900'
                                    : 'bg-slate-300 hover:bg-slate-400',
                            ]"
                            :aria-label="`Maps to slide ${index + 1}`"
                        ></button>
                    </div>
                </div>
            </div>
        </section>

        <section id="experience" class="bg-white py-32 lg:py-44">
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div class="mb-20 grid items-center gap-16 lg:grid-cols-12">
                    <div class="lg:col-span-6">
                        <h2
                            class="mb-4 text-xs font-bold tracking-widest text-blue-900 uppercase"
                        >
                            Exclusivity in Practice
                        </h2>
                        <h3
                            class="font-display text-4xl leading-tight font-bold text-slate-900 lg:text-5xl"
                        >
                            The Practice Experience
                        </h3>
                    </div>
                    <div class="lg:col-span-6 lg:pl-10">
                        <p class="leading-relaxed font-light text-slate-500">
                            We welcome patients into premium spaces optimized
                            for tranquility and medical clinical excellence.
                            From digital configuration suites to curated patient
                            comfort lounges, your journey represents upscale
                            orthodontic care.
                        </p>
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div
                        class="group relative h-80 overflow-hidden bg-slate-100 shadow-sm"
                    >
                        <img
                            src="/images/consultation/consul1.jpg"
                            alt="Bright Smiles Premium Treatment and Consultation Suites"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        />
                        <div
                            class="absolute inset-0 flex items-end bg-linear-to-t from-slate-950/60 via-transparent to-transparent p-8 opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                        >
                            <p
                                class="text-sm font-bold tracking-widest text-white uppercase"
                            >
                                Consultation Area
                            </p>
                        </div>
                    </div>
                    <div
                        class="group relative h-80 overflow-hidden bg-slate-100 shadow-sm"
                    >
                        <img
                            src="/images/kids_area/waiting1.png"
                            alt="Advanced 3D Imaging and Clinical Scanning Infrastructure"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        />
                        <div
                            class="absolute inset-0 flex items-end bg-linear-to-t from-slate-950/60 via-transparent to-transparent p-8 opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                        >
                            <p
                                class="text-sm font-bold tracking-widest text-white uppercase"
                            >
                                Patient waiting room & kids area
                            </p>
                        </div>
                    </div>
                    <div
                        class="group relative h-80 overflow-hidden bg-slate-100 shadow-sm sm:col-span-2 lg:col-span-1"
                    >
                        <img
                            src="/images/reception/rec2.jpg"
                            alt="Bright Smiles Orthodontics Architectural Lounge and Coffee Zone"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        />
                        <div
                            class="absolute inset-0 flex items-end bg-linear-to-t from-slate-950/60 via-transparent to-transparent p-8 opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                        >
                            <p
                                class="text-sm font-bold tracking-widest text-white uppercase"
                            >
                                Reception Area
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section
            id="locations"
            class="border-t border-slate-100 bg-slate-50 py-32 lg:py-44"
        >
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div
                    class="mx-auto mb-24 max-w-2xl text-center"
                    data-aos="fade-up"
                >
                    <h2
                        class="mb-4 text-xs font-bold tracking-widest text-blue-900 uppercase"
                    >
                        Our Clinics
                    </h2>
                    <h3 class="font-display text-4xl font-bold text-slate-900">
                        Convenient Australian Locations
                    </h3>
                </div>

                <div class="grid items-start gap-12 lg:grid-cols-12">
                    <div
                        class="flex flex-col gap-4 lg:col-span-4"
                        data-aos="fade-right"
                    >
                        <button
                            v-for="clinic in clinics"
                            :key="clinic.id"
                            @click="activeClinicId = clinic.id"
                            :class="[
                                'group w-full rounded-none border p-8 text-left transition-all duration-300',
                                activeClinicId === clinic.id
                                    ? 'border-blue-900 bg-white shadow-xl'
                                    : 'border-slate-200 bg-white/60 hover:border-slate-300 hover:bg-white',
                            ]"
                        >
                            <div class="mb-3 flex items-center justify-between">
                                <h4
                                    class="font-display text-xl font-bold text-slate-900"
                                >
                                    {{ clinic.name }}
                                </h4>
                                <i
                                    :class="[
                                        'fa-solid fa-arrow-right text-xs transition-transform',
                                        activeClinicId === clinic.id
                                            ? 'translate-x-1 text-blue-900'
                                            : 'text-slate-400 group-hover:translate-x-1',
                                    ]"
                                ></i>
                            </div>
                            <p
                                class="line-clamp-2 text-xs leading-relaxed font-light text-slate-500"
                            >
                                {{ clinic.address }}
                            </p>
                        </button>
                    </div>

                    <div
                        class="border border-slate-200 bg-white p-6 shadow-sm sm:p-8 lg:col-span-8"
                        data-aos="fade-left"
                    >
                        <transition name="fade" mode="out-in">
                            <div :key="activeClinic.id">
                                <div
                                    class="mb-8 flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-center"
                                >
                                    <div>
                                        <h4
                                            class="font-display mb-2 text-2xl font-bold text-slate-900"
                                        >
                                            {{ activeClinic.name }} Clinic
                                        </h4>
                                        <p
                                            class="text-sm font-light text-slate-500"
                                        >
                                            {{ activeClinic.address }}
                                        </p>
                                    </div>
                                    <a
                                        :href="activeClinic.directionsUrl"
                                        target="_blank"
                                        rel="noopener"
                                        class="flex shrink-0 items-center gap-2 bg-slate-900 px-6 py-4 text-xs font-bold tracking-widest text-white uppercase shadow-sm transition-colors duration-300 hover:bg-blue-900"
                                    >
                                        <i
                                            class="fa-solid fa-route text-xs"
                                        ></i>
                                        Get Directions
                                    </a>
                                </div>

                                <div
                                    class="relative h-112.5 overflow-hidden lg:col-span-3 lg:h-140"
                                    data-aos="fade-left"
                                    data-aos-duration="1000"
                                    data-aos-delay="200"
                                >
                                    <transition name="fade-map" mode="out-in">
                                        <iframe
                                            :key="activeClinic.id"
                                            :src="activeClinic.mapEmbedUrl"
                                            class="h-full w-full rounded-3xl border-0 bg-slate-200 shadow-xl"
                                            :allowfullscreen="true"
                                            loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade"
                                            title="Google Maps Location View Layout"
                                        ></iframe>
                                    </transition>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </section>

        <section
            id="careers"
            class="relative overflow-hidden bg-slate-900 py-32 text-white"
        >
            <div
                class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_right,var(--tw-gradient-stops))] from-blue-400 via-transparent to-transparent opacity-10"
            ></div>

            <div class="relative z-10 mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div
                    class="grid items-center gap-16 lg:grid-cols-12"
                    data-aos="fade-up"
                >
                    <div class="lg:col-span-6">
                        <h2
                            class="mb-4 text-xs font-bold tracking-widest text-blue-400 uppercase"
                        >
                            Careers
                        </h2>
                        <h3
                            class="font-display mb-8 text-4xl font-bold lg:text-5xl"
                        >
                            Join Our Growing Team
                        </h3>
                        <p
                            class="mb-10 max-w-lg text-base leading-relaxed font-light text-slate-400"
                        >
                            We are continually seeking passionate, meticulous
                            dental professionals to join our practice suites.
                            Build your long-term career with Australia's premier
                            digital orthodontic ecosystem.
                        </p>
                        <div
                            class="space-y-4 text-sm font-light text-slate-300"
                        >
                            <p class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-check text-xs text-blue-400"
                                ></i>
                                World-class clinical operating space
                            </p>
                            <p class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-check text-xs text-blue-400"
                                ></i>
                                Continuous precision clinical professional
                                training
                            </p>
                            <p class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-check text-xs text-blue-400"
                                ></i>
                                Cutting-edge 3D diagnostic architecture
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex flex-col justify-center border border-slate-800 bg-slate-950 p-8 text-center shadow-2xl sm:p-12 lg:col-span-6"
                    >
                        <i
                            class="fa-solid fa-envelope-open-text mb-6 text-4xl text-blue-400"
                        ></i>
                        <h4 class="mb-3 text-2xl font-bold">
                            Submit Your Profile
                        </h4>
                        <p class="mb-8 text-sm font-light text-slate-400">
                            Email your structural CV and introductory letter
                            directly to clinical operations.
                        </p>
                        <a
                            href="mailto:info@brightsmilesortho.com.au"
                            class="inline-block bg-white px-8 py-4 text-xs font-bold tracking-widest text-slate-900 uppercase shadow-md transition-all duration-300 hover:bg-blue-400 hover:text-white"
                        >
                            info@brightsmilesortho.com.au
                        </a>

                        <div class="my-8 flex w-full items-center opacity-40">
                            <div class="h-px flex-1 bg-slate-600"></div>
                            <span
                                class="px-4 text-center text-[10px] font-bold tracking-widest text-slate-400 uppercase"
                                >Social Communication</span
                            >
                            <div class="h-px flex-1 bg-slate-600"></div>
                        </div>

                        <div class="flex items-center justify-center gap-6">
                            <a
                                href="https://www.facebook.com/BrightSmilesOrtho"
                                target="_blank"
                                class="group relative flex h-12 w-12 items-center justify-center rounded-full border border-white/10 bg-white/5 transition-all duration-300 hover:-translate-y-1 hover:bg-blue-600"
                                aria-label="Facebook"
                            >
                                <i
                                    class="fa-brands fa-facebook-f text-base text-slate-400 group-hover:text-white"
                                ></i>
                            </a>
                            <a
                                href="https://www.instagram.com/brightsmilesorthodontics"
                                target="_blank"
                                class="group relative flex h-12 w-12 items-center justify-center rounded-full border border-white/10 bg-white/5 transition-all duration-300 hover:-translate-y-1 hover:bg-pink-600"
                                aria-label="Instagram"
                            >
                                <i
                                    class="fa-brands fa-instagram text-base text-slate-400 group-hover:text-white"
                                ></i>
                            </a>
                            <a
                                href="https://www.threads.com/@brightsmilesorthodontics"
                                target="_blank"
                                class="group relative flex h-12 w-12 items-center justify-center rounded-full border border-white/10 bg-white/5 transition-all duration-300 hover:-translate-y-1 hover:bg-black hover:text-slate-950"
                                aria-label="Threads"
                            >
                                <i
                                    class="fa-brands fa-threads text-base text-slate-400 group-hover:text-white"
                                ></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="bg-slate-50 py-32 lg:py-44">
            <div class="mx-auto max-w-3xl px-6 sm:px-8 lg:px-12">
                <div class="mb-20 text-center">
                    <h3 class="font-display text-4xl font-bold text-slate-900">
                        Frequently Asked Questions
                    </h3>
                </div>

                <div class="space-y-4">
                    <div
                        v-for="(faq, index) in faqs"
                        :key="index"
                        class="border border-slate-200/60 bg-white shadow-xs"
                    >
                        <button
                            @click="toggleFaq(index)"
                            class="group flex w-full items-center justify-between px-8 py-6 text-left focus:outline-none"
                        >
                            <span
                                class="text-base font-bold text-slate-900 transition-colors duration-300 group-hover:text-blue-900 sm:text-lg"
                                >{{ faq.question }}</span
                            >
                            <i
                                :class="[
                                    'fa-solid fa-plus text-xs text-blue-900 transition-transform duration-500',
                                    activeFaq === index
                                        ? 'rotate-45 text-slate-400'
                                        : '',
                                ]"
                            ></i>
                        </button>
                        <transition name="accordion">
                            <div
                                v-show="activeFaq === index"
                                class="px-8 pb-6 text-sm leading-relaxed font-light text-slate-500"
                            >
                                {{ faq.answer }}
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </section>

        <section
            id="booking"
            class="border-t border-slate-100 bg-white py-32 lg:py-44"
        >
            <div class="mx-auto max-w-4xl px-6 sm:px-8 lg:px-12">
                <div
                    class="border border-slate-200/60 bg-slate-50 p-8 shadow-xs sm:p-16"
                >
                    <div class="mx-auto mb-16 max-w-xl text-center">
                        <h2
                            class="mb-4 text-xs font-bold tracking-widest text-blue-900 uppercase"
                        >
                            Take the first step
                        </h2>
                        <h3
                            class="font-display mb-4 text-4xl font-bold text-slate-900"
                        >
                            Discover Your Smile Options
                        </h3>
                        <p
                            class="text-sm leading-relaxed font-light text-slate-500"
                        >
                            Submit the diagnostic data request below for a
                            comprehensive consultation appointment at our
                            practice suites.
                        </p>
                    </div>

                    <div v-if="isBookingSubmitted" class="py-16 text-center">
                        <i
                            class="fa-solid fa-circle-check mb-6 text-5xl text-blue-900"
                        ></i>
                        <h3 class="mb-2 text-2xl font-bold text-slate-900">
                            Request Catalogued
                        </h3>
                        <p class="mb-8 text-sm font-light text-slate-500">
                            Our master treatment coordinator will communicate
                            scheduling arrangements shortly.
                        </p>
                        <button
                            @click="resetBooking"
                            class="border-b border-blue-900 pb-1 text-xs font-bold tracking-widest text-blue-900 uppercase hover:text-slate-900"
                        >
                            Submit Alternative Profile Request
                        </button>
                    </div>

                    <form
                        v-else
                        @submit.prevent="submitBooking"
                        class="space-y-8"
                    >
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-bold tracking-widest text-slate-400 uppercase"
                                    >First Name</label
                                >
                                <input
                                    v-model="formData.firstName"
                                    type="text"
                                    class="w-full rounded-none border border-slate-200 bg-white px-5 py-4 text-sm font-light transition-colors outline-none focus:border-slate-400"
                                    required
                                />
                            </div>
                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-bold tracking-widest text-slate-400 uppercase"
                                    >Last Name</label
                                >
                                <input
                                    v-model="formData.lastName"
                                    type="text"
                                    class="w-full rounded-none border border-slate-200 bg-white px-5 py-4 text-sm font-light transition-colors outline-none focus:border-slate-400"
                                    required
                                />
                            </div>
                        </div>
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-bold tracking-widest text-slate-400 uppercase"
                                    >Email Address</label
                                >
                                <input
                                    v-model="formData.email"
                                    type="email"
                                    class="w-full rounded-none border border-slate-200 bg-white px-5 py-4 text-sm font-light transition-colors outline-none focus:border-slate-400"
                                    required
                                />
                            </div>
                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-bold tracking-widest text-slate-400 uppercase"
                                    >Phone Number</label
                                >
                                <input
                                    v-model="formData.phone"
                                    type="tel"
                                    class="w-full rounded-none border border-slate-200 bg-white px-5 py-4 text-sm font-light transition-colors outline-none focus:border-slate-400"
                                    required
                                />
                            </div>
                        </div>
                        <div>
                            <label
                                class="mb-2 block text-[10px] font-bold tracking-widest text-slate-400 uppercase"
                                >How can our team assist your goals?</label
                            >
                            <textarea
                                v-model="formData.message"
                                rows="5"
                                class="w-full resize-none rounded-none border border-slate-200 bg-white px-5 py-4 text-sm font-light transition-colors outline-none focus:border-slate-400"
                            ></textarea>
                        </div>
                        <Link href="/onlineform">
                            <button
                                type="submit"
                                class="w-full bg-slate-900 py-5 text-xs font-bold tracking-widest text-white uppercase shadow-sm transition-colors duration-300 hover:bg-blue-900"
                            >
                                Schedule Your Consultation
                            </button>
                        </Link>
                    </form>
                </div>
            </div>
        </section>

        <footer
            class="border-t border-slate-900 bg-slate-950 py-20 text-xs tracking-wide text-slate-500"
        >
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div class="mb-16 grid grid-cols-1 gap-12 md:grid-cols-12">
                    <div class="md:col-span-5">
                        <img
                            src="/images/BrightSmiles2.png"
                            onerror="
                                this.onerror = null;
                                this.src =
                                    'https://placehold.co/200x60/020617/ffffff?text=Bright+Smiles';
                            "
                            alt="Bright Smiles Ortho Corporate Identity"
                            class="mb-6 h-7 object-contain opacity-90"
                        />
                        <p
                            class="mb-8 max-w-sm leading-relaxed font-light text-slate-400"
                        >
                            A specialist orthodontic group delivering elite
                            patient outcomes through state-of-the-art diagnostic
                            ecosystems and tailored architecture.
                        </p>
                        <div class="flex space-x-5">
                            <a
                                href="https://www.instagram.com/brightsmilesorthodontics"
                                target="_blank"
                                class="text-base text-slate-600 transition-colors duration-300 hover:text-white"
                                aria-label="Instagram Profile Link"
                                ><i class="fa-brands fa-instagram"></i
                            ></a>
                            <a
                                href="https://www.facebook.com/BrightSmilesOrtho"
                                target="_blank"
                                class="text-base text-slate-600 transition-colors duration-300 hover:text-white"
                                aria-label="Facebook Profile Link"
                                ><i class="fa-brands fa-facebook-f"></i
                            ></a>
                            <a
                                href="https://www.threads.com/@brightsmilesorthodontics"
                                target="_blank"
                                class="text-base text-slate-600 transition-colors duration-300 hover:text-white"
                                aria-label="Threads Profile Link"
                                ><i class="fa-brands fa-threads"></i
                            ></a>
                        </div>
                    </div>
                    <div class="md:col-span-3 md:col-start-7">
                        <h4
                            class="mb-6 text-[10px] font-bold tracking-widest text-white uppercase"
                        >
                            Navigation
                        </h4>
                        <ul class="space-y-4 font-medium">
                            <li>
                                <a
                                    href="#about"
                                    class="transition-colors duration-300 hover:text-white"
                                    >Dr Ben Tai</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#transformations"
                                    class="transition-colors duration-300 hover:text-white"
                                    >Clinical Results</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#technology"
                                    class="transition-colors duration-300 hover:text-white"
                                    >Advanced Systems</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#locations"
                                    class="transition-colors duration-300 hover:text-white"
                                    >Practice Locations</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#careers"
                                    class="transition-colors duration-300 hover:text-white"
                                    >Clinical Careers</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#faq"
                                    class="transition-colors duration-300 hover:text-white"
                                    >FAQ Information</a
                                >
                            </li>
                        </ul>
                    </div>
                    <div class="md:col-span-3">
                        <h4
                            class="mb-6 text-[10px] font-bold tracking-widest text-white uppercase"
                        >
                            Central Headquarters
                        </h4>
                        <ul class="space-y-4 font-light text-slate-400">
                            <li class="flex items-start gap-3">
                                <i
                                    class="fa-solid fa-location-dot mt-0.5 text-blue-500"
                                ></i>
                                22B Stirling St, Bunbury WA 6230
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                (08) 9721 6888
                            </li>
                            <li class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-envelope text-blue-500"
                                ></i>
                                info@brightsmilesortho.com.au
                            </li>
                        </ul>
                    </div>
                </div>
                <div
                    class="mt-16 flex flex-col items-center justify-between gap-4 border-t border-slate-900 pt-8 font-light text-slate-600 sm:flex-row"
                >
                    <p>
                        © 2026 Bright Smiles Orthodontic Service. All rights
                        reserved.
                    </p>
                    <div class="flex gap-6">
                        <a
                            href="#"
                            class="transition-colors duration-300 hover:text-slate-400"
                            >Privacy Infrastructure</a
                        >
                        <a
                            href="#"
                            class="transition-colors duration-300 hover:text-slate-400"
                            >Terms of Service Framework</a
                        >
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AOS from 'aos';
import { ref, reactive, onMounted, onUnmounted, computed } from 'vue';
import 'aos/dist/aos.css';

// Hooks Lifecycle Hooks
onMounted(async () => {
    AOS.init({
        once: false,
        offset: 40,
    });
    startAutoplay();
    startAboutAutoplay();
});
onUnmounted(() => {
    clearInterval(autoplayInterval);
    clearInterval(aboutAutoplayInterval);
});
// 1. Mobile Menu State Engine
const isMobileMenuOpen = ref(false);
const toggleMenu = () => (isMobileMenuOpen.value = !isMobileMenuOpen.value);

// 2. Verified Corporate Stat Benchmarks
const stats = [
    { number: '20+', label: 'Years Specialized Experience' },
    { number: '3,500+', label: 'Smiles Artfully Curated' },
    { number: '4.4★', label: 'Unblemished Google Rating' },
    { number: '100%', label: 'Cohesive Digital Workflow' },
];

// 3. Clinical Philosophy Configurations
const reasons = [
    {
        title: 'Specialist Orthodontist',
        desc: 'Expertise cultivated through exhaustive post-graduate academic specialization entirely distinct from base dentistry.',
    },
    {
        title: 'Bespoke Structural Plans',
        desc: 'We reject generic treatments. Every configuration is structurally built for your unique anatomical symmetry.',
    },
    {
        title: 'Advanced Digital Systems',
        desc: 'Banish traditional physical paste configurations. We track structures via high-end 3D spatial optics.',
    },
    {
        title: 'Inconspicuous Frameworks',
        desc: 'From completely hidden internal appliances to pristine customized clear aligner structural pathways.',
    },
    {
        title: 'Structured Financial Paths',
        desc: 'Elite cosmetic health infrastructure made accessible. We arrange modular, interest-free configurations.',
    },
    {
        title: 'Intergenerational Focus',
        desc: 'From crucial interceptive early youth support configurations to advanced mature adult treatments.',
    },
];

// 4. Case Transformations Matrix Data
const transformations = ref([
    {
        id: 1,
        name: 'Emily',
        age: '17',
        treatment: 'Clear Aligners',
        duration: '18 Months',
        quote: 'I used to explicitly mask my profile alignment across media frameworks. Now, my expressive freedom has completely shifted structural dynamics.',
        beforeImg: '/images/emily-before.jpg',
        afterImg: '/images/emily-after.jpg',
    },
    {
        id: 2,
        name: 'Marcus',
        age: '28',
        treatment: 'Ceramic Braces',
        duration: '24 Months',
        quote: 'Operating within high-stakes corporate management parameters required minimal configuration visibility. Dr. Tai engineered an elite framework alignment.',
        beforeImg: '/images/marcus-before.jpg',
        afterImg: '/images/marcus-after.jpg',
    },
]);
const activeTransformIndex = ref(0);
const activeTransformation = computed(
    () => transformations.value[activeTransformIndex.value],
);
const nextTransformation = () =>
    (activeTransformIndex.value =
        (activeTransformIndex.value + 1) % transformations.value.length);
const prevTransformation = () =>
    (activeTransformIndex.value =
        (activeTransformIndex.value - 1 + transformations.value.length) %
        transformations.value.length);

// About Section Autoslide State Config
const currentAboutIndex = ref(0);
let aboutAutoplayInterval: number | undefined;
const aboutImages = ref([
    {
        src: '/images/DrBen/DrBen1.jpeg',
        fallback:
            'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=800&q=80',
        alt: 'Dr. Benjamin Tai Specialist Orthodontist Portrait',
    },
    {
        src: '/images/DrBen/DrBen.png',
        fallback:
            'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=800&q=80',
        alt: 'Dr. Benjamin Tai reviewing treatment blueprints',
    },
    {
        src: '/images/DrBen/DrBen2.png',
        fallback:
            'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=800&q=80',
        alt: 'Premium Orthodontic Consultation Suite',
    },
    {
        src: '/images/DrBen/DrBen3.jpg',
        fallback:
            'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80',
        alt: 'Advanced Digital smile telemetry tracking systems',
    },
]);

const startAboutAutoplay = () => {
    aboutAutoplayInterval = setInterval(() => {
        currentAboutIndex.value =
            (currentAboutIndex.value + 1) % aboutImages.value.length;
    }, 5000); // Slide transitions occur seamlessly every 5 seconds
};

// 5. High-End Technology Infrastructures
const technologies = [
    {
        icon: 'fa-solid fa-laptop-medical',
        title: 'iTero 3D Optics Scanner',
        desc: 'Replaces antiquated, physically structural putties with an absolute cloud-computed geometric model.',
    },
    {
        icon: 'fa-solid fa-print',
        title: '3D Additive Production Lab',
        desc: 'In-house diagnostic printing architectures produce precision appliances, slashing deployment wait parameters.',
    },
    {
        icon: 'fa-solid fa-mobile-screen',
        title: 'Continuous Remote Tracking',
        desc: 'Remotely trace biomechanical drift states via protected patient applications, optimizing physical visits.',
    },
    {
        icon: 'fa-regular fa-face-smile',
        title: 'Predictive Smile Simulation',
        desc: 'Visualize projected outcomes and structural final metrics before active orthodontic mechanics are instantiated.',
    },
];

// 6. Milestone System Journey Configuration
const journeySteps = [
    {
        title: 'Anatomical Analysis',
        desc: 'Engage with Dr. Tai to review facial metrics and map dental structural goals.',
    },
    {
        title: 'High-Precision Scan',
        desc: 'Execute real-time optical scanning matrix computations within moments.',
    },
    {
        title: 'Architectural Blueprint',
        desc: 'Examine your predictive digital structural blueprint timeline roadmap.',
    },
    {
        title: 'Dynamic Correction Journey',
        desc: 'Instantiate corrective structures supported by constant telemetry observation.',
    },
];

// 7. Testimonials Array Engine
const testimonials = ref([
    {
        quote: 'I am thrilled with the results of my dental treatment, and I owe a huge thanks to Dr. Ben. Dr. Ben was instrumental throughout the process. He guided me with expert advice, suggested questions to ask my dentist, and thoroughly explained the risks and benefits of each option. His dedication to ensuring I received the best possible treatment made the entire journey smooth, even though my case was quite complicated. I am so grateful my dentist referred me to him. Thank you, Dr. Ben, for restoring my confidence and making me feel great about my smile again!',
        name: 'Hellen M.',
        treatment: 'Adult Orthodontics',
    },
    {
        quote:
            'Thank you to Ben for the comfortable & knowledgeable experience of taking my son through the process of applying, maintaining & removal of his braces.\n' +
            'The intricate attention to detail in creating the perfect results.\n' +
            'We are very happy & shall continue the visits to keep the perfect smile 😁',
        name: 'Ri Ri S.',
        treatment: 'Teen Orthodontics',
    },
    {
        quote: 'Dr Ben Tai is a high-standard professional, I am 3 years post braces removal and I love my smile! I always get compliments on it. I started to get some teeth shifting due to not wearing my retainers on several occasions, and Dr Tai booked me in immediately after emailing him and sorted me out.',
        name: 'Sevasti S.',
        treatment: 'Comprehensive Braces',
    },
]);
const currentIndex = ref(0);
let autoplayInterval: number | undefined;
const setSlide = (index: number) => {
    currentIndex.value = index;
    resetAutoplay();
};
const startAutoplay = () => {
    autoplayInterval = setInterval(() => {
        currentIndex.value =
            (currentIndex.value + 1) % testimonials.value.length;
    }, 7000);
};
const resetAutoplay = () => {
    clearInterval(autoplayInterval);
    startAutoplay();
};

// 8. Practice Location Registries
const activeClinicId = ref('bunbury');
const clinics = [
    {
        id: 'bunbury',
        name: 'Bunbury Suite',
        address:
            'Bright Smiles Bunbury Orthodontic Centre, 22B Stirling St, Bunbury WA 6230',
        mapEmbedUrl:
            'https://maps.google.com/maps?q=Bright%20Smiles%20Bunbury%20Orthodontic%20Centre,%2022B%20Stirling%20St,%20Bunbury%20WA%206230&t=&z=15&ie=UTF8&iwloc=&output=embed',
        directionsUrl:
            'https://www.google.com/maps/dir/?api=1&destination=Bright+Smiles+Bunbury+Orthodontic+Centre,+22B+Stirling+St,+Bunbury+WA+6230',
    },
];
const activeClinic = computed(() => {
    return clinics.find((c) => c.id === activeClinicId.value) || clinics[0];
});

// 9. FAQ Structure Node
const faqs = [
    {
        question:
            'Am I too advanced in years for specialist care configuration?',
        answer: 'Anatomical structures can adapt effectively across any generation. Nearly 30% of our active diagnostic patients represent established adults correcting aesthetic profiles.',
    },
    {
        question:
            'Will the corrective structural adjustments cause severe discomfort?',
        answer: 'Modern setups utilize light, sequential physical dynamic adjustments. Minor structural awareness is temporary, passing inside consecutive hours.',
    },
    {
        question: 'What timeline applies to complete orthodontic alignment?',
        answer: 'Chronological parameters range across 6 to 24 months based on tracking indicators. Your initial consultation configuration outlines absolute specific guidelines.',
    },
    {
        question:
            'Can clear aligner software replace standard hardware matrices entirely?',
        answer: 'Generally, yes. Dr. Tai specializes within advanced clear aligner deployment mechanics and will select options matching your functional bite vectors.',
    },
];
const activeFaq = ref<number | null>(null);
const toggleFaq = (index: number) =>
    (activeFaq.value = activeFaq.value === index ? null : index);

// 10. Core Communication Form System
const isBookingSubmitted = ref(false);
const formData: any = reactive({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    message: '',
});
const submitBooking = () => {
    setTimeout(() => (isBookingSubmitted.value = true), 500);
};
const resetBooking = () => {
    Object.keys(formData).forEach((key) => (formData[key] = ''));
    isBookingSubmitted.value = false;
};
</script>

<style scoped>
/* Typography Architecture for Ultra-Luxury Experience */
.font-display {
    font-family: 'Playfair Display', serif;
}
.font-sans {
    font-family: 'Inter', sans-serif;
}

/* Clean UI Animations */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* Accordion Component Transition Rules */
.accordion-enter-active,
.accordion-leave-active {
    transition:
        max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1),
        opacity 0.3s ease;
    max-height: 250px;
    overflow: hidden;
}
.accordion-enter-from,
.accordion-leave-to {
    max-height: 0;
    opacity: 0;
}
</style>
