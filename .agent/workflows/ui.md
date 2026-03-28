---
description: Guidelines for building beautiful, consistent, and responsive UI components using Blade and Tailwind.
---

### UI/UX Consistency Workflow (Laravel/Blade Edition)

1. **Component Selection**: Always check `resources/views/partials` or `resources/views/layouts` first. Reuse existing layouts and icon partials (`resources/views/icons/`).
2. **Design Language**: 
   - Use the established color palette in `tailwind.config.js`.
   - Maintain the identical visual structure as the Next.js version (Sidebar, Top Header with Alpine.js dropdowns).
3. **Interactivity**: 
   - Use **Alpine.js** (`x-data`, `v-show`, `@click`) for dropdowns, modals, tabs, and simple UI toggles. Do NOT use React or heavy Javascript.
4. **Icons**: 
   - Use the pre-converted SVG Blade files (e.g., `@include('icons.search')`). If an icon is missing, extract the inline SVG from Lucide and save it as a blade file.
5. **Responsiveness**: Verify the layout works on mobile and desktop using standard Tailwind utility classes.
