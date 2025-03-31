<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

localStorage.removeItem('authToken')
localStorage.removeItem('authUserName')
localStorage.removeItem('salesCache')
localStorage.removeItem('sellersCache')

router.push('/login')

</script>