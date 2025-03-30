<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

localStorage.removeItem('authToken')

router.push('/login')

</script>