import { fieldRegistry } from "sulu-admin-bundle/containers";
import VideoPreview from "./containers/VideoPreview";

const FIELD_TYPE_VIDEO = "video";

fieldRegistry.add(FIELD_TYPE_VIDEO, VideoPreview);
